<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Akses tidak diizinkan. Hanya admin yang dapat mengakses halaman ini.');
        }

        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun admin Anda telah dinonaktifkan. Hubungi administrator sistem.');
        }

        return $next($request);
    }
}