<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role-nya 'owner'
        // (Pastikan di tabel users kolom 'role' isinya 'owner' ya)
        if (Auth::user()->role !== 'owner') {
            // Kalau bukan owner, kasih error 403 (Forbidden)
            abort(403, 'MAAF! Halaman ini khusus Owner/Eksekutif.');
        }

        // 3. Kalau lolos, silakan lanjut
        return $next($request);
    }
}