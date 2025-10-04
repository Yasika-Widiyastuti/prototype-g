<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditLogHelper; // ✅ tambahkan ini

class LoginController extends Controller
{
    protected function redirectTo()
    {
        $user = Auth::user();
        return $user->isAdmin() ? route('admin.dashboard') : route('home');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ catat log login
            AuditLogHelper::log(
                $user->id,
                'login',
                'User berhasil login',
                [
                    'email' => $user->email,
                    'remember' => $remember,
                ]
            );

            return $user->isAdmin()
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended(route('home'));
        }

        // ✅ catat log gagal login
        AuditLogHelper::log(
            null,
            'failed_login',
            'Percobaan login gagal',
            [
                'email' => $request->email,
            ]
        );

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        // ✅ catat log logout sebelum session dihancurkan
        if (Auth::check()) {
            $user = Auth::user();
            AuditLogHelper::log(
                $user->id,
                'logout',
                'User logout dari sistem',
                ['email' => $user->email]
            );
        }



        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
