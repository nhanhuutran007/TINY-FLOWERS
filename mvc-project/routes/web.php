<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    $products = \App\Models\Product::with('category')->where('status', 1)->latest()->take(8)->get();
    return view('welcome', compact('products'));
})->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/collections', [ShopController::class, 'collections'])->name('collections');

Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});

// CART ROUTES
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// CHECKOUT ROUTES (Requires Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// LOGIN ROUTES
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'postLogin'])->name('login.post');

// REGISTER & FORGOT PASSWORD
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'postRegister'])->name('register.post');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function () {
    return redirect()->route('password.verify.view', ['email' => request('email')]);
})->name('password.email');

Route::get('/verify-code', function () {
    return view('auth.verify-code', ['email' => request('email')]);
})->name('password.verify.view');

Route::post('/verify-code', function () {
    return redirect()->route('password.reset.view');
})->name('password.verify');

Route::get('/reset-password', function () {
    return "Trang đặt lại mật khẩu (Sẽ được triển khai ở bước sau)";
})->name('password.reset.view');

// Favorites
Route::post('/favorites/{product}', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle')->middleware('auth');
Route::get('/profile/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('profile.favorites')->middleware('auth');

// DASHBOARD & PROTECTED ROUTES
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Các route quản lý khác (Tạm thời bỏ middleware để bạn dễ test giao diện)
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('customers', CustomerController::class);
Route::resource('users', UserController::class);
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
Route::get('/change-password', [UserController::class, 'changePasswordView'])->name('profile.password');
Route::post('/change-password', [UserController::class, 'updatePassword'])->name('profile.password.update');
Route::get('/address', [UserController::class, 'addressView'])->name('profile.address');
Route::post('/address', [UserController::class, 'updateAddress'])->name('profile.address.update');
Route::get('/profile/orders', [UserController::class, 'ordersView'])->name('profile.orders');

Route::get('/api/stock-alerts', [\App\Http\Controllers\StockAlertController::class, 'index']);
