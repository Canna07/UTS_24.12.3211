<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class CheckoutController extends Controller
{

    private function initMidtrans(): void
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized  = config('midtrans.is_sanitized', true);
        Config::$is3ds        = config('midtrans.is_3ds', true);
    }

    public function create(Event $event)
    {
        // Cek stok sebelum menampilkan halaman checkout
        if ($event->stock <= 0) {
            return redirect()->back()
                ->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $categories = Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    /**
     * Proses checkout & generate Snap Token
     */
    public function store(Request $request, Event $event)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // 2. Cek stok awal
        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        try {
            // 3. Inisialisasi Midtrans SEBELUM DB Transaction
            $this->initMidtrans();

            // 4. Siapkan data transaksi
            $orderId    = 'TRX-' . time() . '-' . strtoupper(Str::random(5));
            $totalPrice = (int) ($event->price + 5000); // Harga + Admin Fee

            // 5. Split nama untuk Midtrans
            $nameParts = explode(' ', trim($validated['customer_name']), 2);
            $firstName = $nameParts[0];
            $lastName  = $nameParts[1] ?? '';

            // 6. Parameter Midtrans
            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'email'      => $validated['customer_email'],
                    'phone'      => $validated['customer_phone'],
                ],
                'item_details' => [
                    [
                        'id'       => $event->id,
                        'price'    => (int) $event->price,
                        'quantity' => 1,
                        'name'     => substr($event->name, 0, 50), // Midtrans max 50 char
                    ],
                    [
                        'id'       => 'ADMIN-FEE',
                        'price'    => 5000,
                        'quantity' => 1,
                        'name'     => 'Admin Fee',
                    ],
                ],
            ];

        
            $snapToken = Snap::getSnapToken($params);

            if (empty($snapToken)) {
                throw new \Exception('Gagal mendapatkan Snap Token dari Midtrans.');
            }

            // 8. Simpan ke database dalam DB Transaction
            $transaction = DB::transaction(function () use ($validated, $event, $orderId, $totalPrice, $snapToken) {

                // Re-check stok dengan lock untuk mencegah race condition
                $freshEvent = Event::lockForUpdate()->findOrFail($event->id);

                if ($freshEvent->stock <= 0) {
                    throw new \Exception('Mohon maaf, tiket untuk acara ini sudah habis.');
                }

                // Simpan transaksi sekaligus dengan snap_token
                return Transaction::create([
                    'event_id'       => $freshEvent->id,
                    'order_id'       => $orderId,
                    'customer_name'  => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'],
                    'total_price'    => $totalPrice,
                    'status'         => 'pending',
                    'snap_token'     => $snapToken,
                ]);
            });

            return redirect()->route('checkout.payment', $transaction->order_id);

        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage(), [
                'event_id' => $event->id,
                'request'  => $request->except('_token'),
            ]);

            return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }

  
    public function payment(string $order_id)
    {
        $categories  = Category::all();
        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        // Jika sudah success, redirect ke halaman sukses
        if ($transaction->status === 'success') {
            return redirect()->route('checkout.success', $order_id);
        }

        return view('checkout.payment', compact('transaction', 'categories'));
    }

  
    public function success(string $order_id)
    {
        $categories  = Category::all();
        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        // Jika sudah success, tidak perlu cek ke Midtrans lagi
        if ($transaction->status === 'success') {
            return view('checkout.success', compact('transaction', 'categories'));
        }

        try {
            $this->initMidtrans();

            // Ambil status transaksi dari Midtrans API
            $midtransStatus = MidtransTransaction::status($order_id);

            $transactionStatus = $midtransStatus->transaction_status ?? null;
            $fraudStatus       = $midtransStatus->fraud_status ?? null;

            // Validasi status pembayaran
            $isSuccess = in_array($transactionStatus, ['capture', 'settlement']) &&
                         in_array($fraudStatus, ['accept', null]);

            if ($isSuccess) {
                DB::transaction(function () use ($transaction) {
                    // Update status transaksi
                    $transaction->update(['status' => 'success']);

                    // Kurangi stok dengan lock untuk mencegah race condition
                    $event = Event::lockForUpdate()->find($transaction->event_id);

                    if ($event && $event->stock > 0) {
                        $event->decrement('stock', 1);
                    }
                });

                // Refresh data setelah update
                $transaction->refresh();

            } elseif ($transactionStatus === 'deny') {
                $transaction->update(['status' => 'failed']);
                return redirect()->route('home')
                    ->with('error', 'Pembayaran ditolak. Silakan coba lagi.');

            } elseif (in_array($transactionStatus, ['cancel', 'expire'])) {
                $transaction->update(['status' => 'cancelled']);
                return redirect()->route('home')
                    ->with('error', 'Transaksi dibatalkan atau kadaluarsa.');
            }

        } catch (\Exception $e) {
            Log::error('Midtrans Status Check Error: ' . $e->getMessage(), [
                'order_id' => $order_id,
            ]);

            return redirect()->route('home')
                ->with('error', 'Gagal memverifikasi status pembayaran: ' . $e->getMessage());
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }


    public function notification(Request $request)
    {
        try {
            $this->initMidtrans();

            $notification      = new \Midtrans\Notification();
            $orderId           = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;

            $transaction = Transaction::where('order_id', $orderId)->firstOrFail();

            DB::transaction(function () use ($transaction, $transactionStatus, $fraudStatus) {
                if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
                    $this->markAsSuccess($transaction);

                } elseif ($transactionStatus === 'settlement') {
                    $this->markAsSuccess($transaction);

                } elseif (in_array($transactionStatus, ['cancel', 'expire'])) {
                    $transaction->update(['status' => 'cancelled']);

                } elseif ($transactionStatus === 'deny') {
                    $transaction->update(['status' => 'failed']);

                } elseif ($transactionStatus === 'pending') {
                    $transaction->update(['status' => 'pending']);
                }
            });

            return response()->json(['message' => 'Notification handled successfully.'], 200);

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    private function markAsSuccess(Transaction $transaction): void
    {
        if ($transaction->status !== 'success') {
            $transaction->update(['status' => 'success']);

            $event = Event::lockForUpdate()->find($transaction->event_id);
            if ($event && $event->stock > 0) {
                $event->decrement('stock', 1);
            }
        }
    }
}