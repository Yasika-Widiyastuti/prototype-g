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

        // Jika akun nonaktif, logout dan minta login
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('signIn')
                ->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        // Hanya customer yang boleh lanjut
        if (!$user->isCustomer()) {
            // Kalau admin mencoba akses halaman user
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Admin tidak dapat mengakses halaman customer.');
            }
            // Role lain -> Forbidden
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}