<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('signIn')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Hanya customer yang boleh lanjut
        if (!$user->isCustomer()) {
            // Kalau admin mencoba, redirect ke dashboard admin
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Admin tidak dapat mengakses halaman pengguna.');
            }
            // Role lain -> Forbidden
            abort(403, 'Akses tidak diizinkan.');
        }

        // Jika akun nonaktif, logout dan minta login
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('signIn')
                ->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        return $next($request);
    }
}
