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
            'ktp.mimes' => 'Format KTP harus JPG, PNG, atau PDF.',
            'ktp.max' => 'Ukuran KTP maksimal 5MB.',
            'kk.required' => 'KK harus diupload.',
            'kk.mimes' => 'Format KK harus JPG, PNG, atau PDF.',
            'kk.max' => 'Ukuran KK maksimal 5MB.',
            'agree.required' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        $ktpPath = null;
        $kkPath = null;

        // ✅ Upload KTP dengan nama unik
        if ($request->hasFile('ktp')) {
            $ktpFile = $request->file('ktp');
            $ktpName = 'ktp_' . time() . '_' . uniqid() . '.' . $ktpFile->getClientOriginalExtension();
            $ktpPath = $ktpFile->storeAs('documents/ktp', $ktpName, 'public');
        }

        // ✅ Upload KK dengan nama unik
        if ($request->hasFile('kk')) {
            $kkFile = $request->file('kk');
            $kkName = 'kk_' . time() . '_' . uniqid() . '.' . $kkFile->getClientOriginalExtension();
            $kkPath = $kkFile->storeAs('documents/kk', $kkName, 'public');
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
            'role' => 'customer',
            'is_active' => true,
            'verification_status' => 'pending',
        ]);

        return redirect()->route('signIn')->with('success', 'Akun berhasil dibuat! Silakan login dan tunggu verifikasi dari admin.');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}