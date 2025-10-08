<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Cek login
        if (!$user) {
            return redirect()->route('signIn')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Admin dan role lain selain customer bypass
        if ($user->role !== 'customer') {
            return $next($request);
        }

        // Cek hanya pada route checkout
        $checkoutRoutes = ['checkout.index', 'checkout.payment', 'checkout.payment.submit'];

        if (in_array($request->route()->getName(), $checkoutRoutes)) {

            if ($user->verification_status === 'pending') {
                return redirect()->route('checkout.index')
                    ->with('warning', 'Akun Anda masih menunggu verifikasi. Anda tidak dapat melanjutkan checkout.');
            }

            if ($user->verification_status === 'rejected') {
                return redirect()->route('checkout.index')
                    ->with('error', 'Verifikasi akun Anda ditolak. Alasan: ' . ($user->verification_notes ?? 'Tidak ada catatan dari admin.'));
            }

            if (!$user->is_active) {
                return redirect()->route('checkout.index')
                    ->with('error', 'Akun Anda sedang dinonaktifkan. Silakan hubungi admin.');
            }
        }

        // Jika lolos semua pengecekan
        return $next($request);
    }
}