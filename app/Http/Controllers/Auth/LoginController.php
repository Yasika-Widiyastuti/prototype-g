<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditLogHelper;

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

            // Catat log login berhasil
            AuditLogHelper::log(
                $user->id,
                'login',
                'User berhasil login',
                [
                    'email' => $user->email,
                    'remember' => $remember,
                ]
            );

            // Redirect sesuai role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            if ($user->isCustomer()) {
                return redirect()->intended(route('home'));
            }

            // Kalau role tidak valid
            Auth::logout();
            return redirect()->route('signIn')->with('error', 'Role pengguna tidak valid.');
        }

        // Login gagal - catat log
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
        // Catat log logout
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