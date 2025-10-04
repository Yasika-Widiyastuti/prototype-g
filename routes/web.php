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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileOrderController;


// ==========================
// Auth Routes (Only for guests)
// ==========================
Route::middleware('guest')->group(function () {
    Route::get('/create-account', [RegisterController::class, 'showCreateForm'])->name('create-account');
    Route::post('/create-account', [RegisterController::class, 'storeAccount'])->name('create.account.store');

    Route::get('/sign-in', fn () => view('auth.login'))->name('signIn');
    Route::post('/sign-in', [LoginController::class, 'login'])->name('login');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================
// Main Pages
// ==========================
Route::view('/', 'welcome')->name('home');
Route::view('/tentang-kami', 'pages.tentang-kami')->name('tentangKami');
Route::view('/hubungi-kami', 'pages.hubungi-kami')->name('hubungi');
Route::view('/terms-and-conditions', 'pages.terms-and-conditions')->name('termsAndConditions');

// ==========================
// Product Routes
// ==========================
Route::get('/shop', [ProductController::class, 'index'])->name('shop');

Route::get('/handphone', [ProductController::class, 'handphoneIndex'])->name('handphone.index');
Route::get('/lightstick', [ProductController::class, 'lightstickIndex'])->name('lightstick.index');
Route::get('/powerbank', [ProductController::class, 'powerbankIndex'])->name('powerbank.index');

Route::get('/handphone/{id}', [ProductController::class, 'handphoneShow'])->name('handphone.show');
Route::get('/lightstick/{id}', [ProductController::class, 'lightstickShow'])->name('lightstick.show');
Route::get('/powerbank/{id}', [ProductController::class, 'powerbankShow'])->name('powerbank.show');

// ==========================
// Cart Routes (auth required)
// ==========================
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/handphone/{id}', [ProductController::class, 'addToCart'])->name('cart.add.handphone');
    Route::post('/cart/add/lightstick/{id}', [ProductController::class, 'addToCart'])->name('cart.add.lightstick');
    Route::post('/cart/add/powerbank/{id}', [ProductController::class, 'addToCart'])->name('cart.add.powerbank');
});

// ==========================
// Checkout Flow (auth required)
// ==========================
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    // Step 1: Checkout
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    // Step 2: Payment (pilih bank)
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/payment', [CheckoutController::class, 'processPayment'])->name('payment.submit');
    // Step 3: Confirmation
    Route::get('/confirmation', [CheckoutController::class, 'confirmation'])->name('confirmation');
    // Step 4: Upload bukti transfer
    Route::post('/status', [CheckoutController::class, 'paymentStatus'])->name('status');
    // Cart management routes
    Route::post('/update-quantity', [CheckoutController::class, 'updateQuantity'])->name('update-quantity');
    Route::post('/remove-item', [CheckoutController::class, 'removeItem'])->name('remove-item');
});

// ==========================
// User Profile (auth required)
// ==========================
Route::middleware('auth')->group(function () {
    // Show profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
      
    // Edit profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    
    // Delete account
    Route::delete('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');

    // 👇 Tambahin ini untuk Pesanan Saya
    Route::get('/profile/orders', [ProfileOrderController::class, 'index'])->name('profile.orders');
    Route::get('/profile/orders/{id}', [ProfileOrderController::class, 'show'])->name('profile.orders.show');
});


// ==========================
// Debug Route (auth required)
// ==========================
Route::get('/debug-cart', function () {
    return response()->json([
        'cart' => session('cart', []),
        'cart_count' => session('cart_count', 0),
        'all_session' => session()->all(),
        'session_id' => session()->getId()
    ]);
})->middleware('auth');

// ==========================
// Admin Routes
// ==========================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Payments
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::patch('/payments/{payment}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.update-status');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    Route::patch('/products/{product}/toggle-availability', [AdminProductController::class, 'toggleAvailability'])->name('products.toggle-availability');
    Route::post('/products/bulk-update-stock', [AdminProductController::class, 'bulkUpdateStock'])->name('products.bulkUpdateStock');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::post('/products/{id}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store')
        ->middleware('auth');

    Route::get('/lightstick/{id}', [ProductController::class, 'lightstickShow'])
        ->name('lightstick.show');
    Route::get('/handphone/{id}', [ProductController::class, 'handphoneShow'])
        ->name('handphone.show');
    Route::get('/powerbank/{id}', [ProductController::class, 'powerbankShow'])
        ->name('powerbank.show');
});
