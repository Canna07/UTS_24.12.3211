@extends('layouts.app')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <!-- Header -->
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black">Dashboard Ringkasan</h1>
            <p class="text-slate-500 font-medium">Selamat datang kembali, Admin!</p>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-right hidden md:block">
                <p class="font-bold">Admin Super</p>
                <p class="text-xs text-slate-400">Penyelenggara Utama</p>
            </div>

            <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center p-1">
                <img src="https://ui-avatars.com/api/?name=Admin+Super&background=6366f1&color=fff"
                    class="rounded-xl">
            </div>
        </div>
    </header>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <!-- Total Pendapatan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-slate-400 text-sm font-bold uppercase mb-2">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-indigo-600">
                Rp {{ number_format($totalRevenue,0,',','.') }}
            </h3>
        </div>

        <!-- Tiket -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-slate-400 text-sm font-bold uppercase mb-2">Tiket Terjual</p>
            <h3 class="text-2xl font-black">
                {{ number_format($ticketsSold,0,',','.') }}
            </h3>
        </div>

        <!-- Event -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-slate-400 text-sm font-bold uppercase mb-2">Event Aktif</p>
            <h3 class="text-2xl font-black">
                {{ $activeEvents }} Event
            </h3>
        </div>

        <!-- Pending -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-slate-400 text-sm font-bold uppercase mb-2">Pesanan Pending</p>
            <h3 class="text-2xl font-black text-red-500">
                {{ $pendingOrders }} Pesanan
            </h3>
        </div>

    </div>

    <!-- Transaksi -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="p-8 border-b flex justify-between items-center">
            <h3 class="font-black text-xl">Transaksi Terakhir</h3>

            <a href="{{ route('admin.transactions.index') }}"
                class="text-indigo-600 font-bold hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead class="bg-slate-50 uppercase text-xs text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Pembeli</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($recentTransactions as $trx)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">
                            {{ $trx->created_at->format('d M Y H:i') }}
                            <br>
                            <small class="text-gray-400">
                                {{ $trx->order_id }}
                            </small>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-semibold">
                                {{ $trx->customer_name }}
                            </div>

                            <small class="text-gray-500">
                                {{ $trx->customer_email }}
                            </small>
                        </td>

                        <td class="px-6 py-4">
                            {{ $trx->event->title ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            @if($trx->status=='success' || $trx->status=='settlement')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs font-bold">
                                    SUCCESS
                                </span>

                            @elseif($trx->status=='pending')

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-xs font-bold">
                                    PENDING
                                </span>

                            @elseif($trx->status=='failed')

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs font-bold">
                                    FAILED
                                </span>

                            @else

                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs font-bold">
                                    {{ strtoupper($trx->status) }}
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-right font-bold text-indigo-600">
                            Rp {{ number_format($trx->total_price,0,',','.') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">
                            Belum ada transaksi.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection