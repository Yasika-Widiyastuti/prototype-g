<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditLogHelper;
use App\Models\Cart; // <-- PENTING: Import Model Cart
use App\Models\Product; // <-- PENTING: Import Model Product
use Carbon\Carbon; // <-- PENTING: Import Carbon untuk Tanggal

class LoginController extends Controller
{
    protected function redirectTo()
    {
        $user = Auth::user();
        // PERBAIKAN 1: Cek di method redirectTo juga
        if ($user->role === 'owner') {
            return route('owner.dashboard');
        }
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
            
            // 🚫 Cek apakah akun nonaktif
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('signIn')->with('error', 'Akun Anda telah dinonaktifkan.');
            }
            // =======================================================
            // START LOGIKA PENGGABUNGAN KERANJANG (CART MERGE)
            // =======================================================
            if (session('cart')) {
                $sessionCart = session('cart');
                \Log::info('Merging session cart to database for user:', ['user_id' => $user->id, 'session_items' => count($sessionCart)]);

                foreach ($sessionCart as $cartKey => $sessionItem) {
                    $productId = $sessionItem['id'];

                    // Cek apakah item sudah ada di keranjang database milik user
                    $dbCartItem = Cart::firstOrNew([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                    ]);

                    if ($dbCartItem->exists) {
                        // Item sudah ada di DB: Tambahkan kuantitasnya
                        $dbCartItem->quantity += $sessionItem['quantity'];
                    } else {
                        // Item belum ada di DB: Buat baru dengan data dari session
                        $dbCartItem->quantity = $sessionItem['quantity'];
                        
                        // Set tanggal default untuk item yang baru digabungkan (1 hari sewa)
                        $dbCartItem->start_date = Carbon::now()->toDateString();
                        $dbCartItem->end_date = Carbon::now()->addDay()->toDateString();
                        $dbCartItem->duration = 1; 
                    }
                    
                    // Pastikan stock masih tersedia sebelum menyimpan/menggabungkan
                    $product = Product::find($productId);
                    if ($product && $product->stock >= $dbCartItem->quantity) {
                        $dbCartItem->save();
                    } else {
                        // Jika stok tidak cukup, item di session tidak akan digabungkan
                        \Log::warning('Skipped merging item due to insufficient stock.', ['product_id' => $productId, 'requested_quantity' => $dbCartItem->quantity]);
                    }
                }

                // Setelah semua digabungkan, hapus keranjang dari session
                $request->session()->forget('cart');
                
                \Log::info('Session cart merged successfully and cleared.');
            } 
            
            // Pastikan cart_count di session diupdate ke jumlah item di DB
            $totalUniqueItems = Cart::where('user_id', $user->id)->count();
            $request->session()->put('cart_count', $totalUniqueItems);
            // =======================================================
            // END LOGIKA PENGGABUNGAN KERANJANG (CART MERGE)
            // =======================================================


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

            // 2. Cek Owner (INI YANG BARU DITAMBAHKAN) ✅
            if ($user->role === 'owner') {
                return redirect()->intended(route('owner.dashboard'));
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

        // --- START PERBAIKAN: Membersihkan sesi keranjang sementara ---
        // Ini memastikan bahwa saat user logout, data cart yang 
        // tersisa di session (yang seharusnya sudah digabungkan ke DB)
        // atau counter sementara dihapus. Cart di database (DB) TIDAK dihapus.
        $request->session()->forget('cart');
        $request->session()->forget('cart_count');
        // --- END PERBAIKAN ---

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signIn')->with('success', 'Berhasil logout');
    }
}
