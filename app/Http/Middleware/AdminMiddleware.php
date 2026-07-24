<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        // Cek role admin
        if (auth()->user()->role != 'admin') {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}