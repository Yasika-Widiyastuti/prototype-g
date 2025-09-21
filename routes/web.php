<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\AdminProductController;


// Auth Routes (Only accessible for guests)
Route::middleware('guest')->group(function () {
    // Route for showing registration form
    Route::get('/create-account', [RegisterController::class, 'showCreateForm'])->name('create-account');
    Route::post('/create-account', [RegisterController::class, 'storeAccount'])->name('create.account.store');
    
    // Route for showing login form
    Route::get('/sign-in', function () { return view('auth.login'); })->name('signIn');
    Route::post('/sign-in', [LoginController::class, 'login'])->name('login');
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Main Pages (No Authentication Required)
Route::view('/', 'welcome')->name('home');
Route::view('/tentang-kami', 'pages.tentang-kami')->name('tentangKami');
Route::view('/hubungi-kami', 'pages.hubungi-kami')->name('hubungi');
Route::view('/terms-and-conditions', 'pages.terms-and-conditions')->name('termsAndConditions');

// Product Routes (For Showing Products and Categories)
Route::get('/shop', [ProductController::class, 'index'])->name('shop');

// Categories Routes
Route::get('/handphone', [ProductController::class, 'handphoneIndex'])->name('handphone.index');
Route::get('/lightstick', [ProductController::class, 'lightstickIndex'])->name('lightstick.index');
Route::get('/powerbank', [ProductController::class, 'powerbankIndex'])->name('powerbank.index');

// Product Details Routes (For Viewing Details of Each Product)
Route::get('/handphone/{id}', [ProductController::class, 'handphoneShow'])->name('handphone.show');
Route::get('/lightstick/{id}', [ProductController::class, 'lightstickShow'])->name('lightstick.show');
Route::get('/powerbank/{id}', [ProductController::class, 'powerbankShow'])->name('powerbank.show');

// Cart Routes - Available to all users (but will redirect to login if not authenticated)
Route::post('/cart/add/handphone/{id}', [ProductController::class, 'addToCart'])->name('cart.add.handphone')->middleware('auth');
Route::post('/cart/add/lightstick/{id}', [ProductController::class, 'addToCart'])->name('cart.add.lightstick')->middleware('auth');
Route::post('/cart/add/powerbank/{id}', [ProductController::class, 'addToCart'])->name('cart.add.powerbank')->middleware('auth');

// Checkout Flow (Requires Authentication)
Route::middleware('auth')->group(function () {
    // Checkout Steps
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/pembayaran', [CheckoutController::class, 'payment'])->name('payment');
    Route::get('/payment/confirmation', [CheckoutController::class, 'confirmation'])->name('payment.confirmation');
    Route::post('/payment/status', [CheckoutController::class, 'paymentStatus'])->name('payment.status');
});

// User Profile Routes (Requires Authentication)
Route::middleware('auth')->group(function () {
    // Show profile
    Route::get('/profile', [RegisterController::class, 'showProfile'])->name('profile');
    
    // Edit profile
    Route::get('/profile/edit', [RegisterController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [RegisterController::class, 'updateProfile'])->name('profile.update');
    
    // Delete account
    Route::delete('/profile/delete', [RegisterController::class, 'deleteAccount'])->name('profile.delete');
});

// Debug route untuk melihat isi session
Route::get('/debug-cart', function () {
    return response()->json([
        'cart' => session('cart', []),
        'cart_count' => session('cart_count', 0),
        'all_session' => session()->all(),
        'session_id' => session()->getId()
    ]);
})->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Payment Management
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::patch('/payments/{payment}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.update-status');
    
    // Orders (gunakan controller yang sudah ada, tapi update)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Product Management dengan method tambahan
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create'); // tambahkan ini
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store'); // untuk submit form tambah

    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit'); // untuk halaman edit
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update'); // untuk submit edit

    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    Route::patch('/products/{product}/toggle-availability', [AdminProductController::class, 'toggleAvailability'])->name('products.toggle-availability');
    Route::post('/products/bulk-update-stock', [AdminProductController::class, 'bulkUpdateStock'])->name('admin.products.bulkUpdateStock');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    
    // Reports (gunakan yang sudah ada)  
#    Route::prefix('reports')->name('reports.')->group(function () {
#        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
#        Route::get('/products', [ReportController::class, 'products'])->name('products');
#        Route::get('/customers', [ReportController::class, 'customers'])->name('customers');
    });
