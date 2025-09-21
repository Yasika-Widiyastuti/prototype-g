<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function showCreateForm()
    {
        return view('auth.register');
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'agree' => 'required|accepted',
        ], [
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.required' => 'Nomor HP harus diisi.',
            'address.required' => 'Alamat harus diisi.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'ktp.required' => 'KTP harus diupload.',
            'kk.required' => 'KK harus diupload.',
            'agree.required' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        $ktpPath = null;
        $kkPath = null;

        if ($request->hasFile('ktp')) {
            $ktpPath = $request->file('ktp')->store('public/documents');
        }

        if ($request->hasFile('kk')) {
            $kkPath = $request->file('kk')->store('public/documents');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'ktp_path' => $ktpPath,
            'kk_path' => $kkPath,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('signIn')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
}