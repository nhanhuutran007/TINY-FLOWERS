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

Route::get('/', function () {
    return view('welcome');
});

// LOGIN ROUTES
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $email = request('email');
    $password = request('password');

    if (($email === 'admin' || $email === 'admin@admin.com') && $password === 'admin') {
        Session::put('authenticated', true);
        Session::put('user', ['name' => 'Admin User', 'email' => 'admin@admin.com']);
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'Tài khoản hoặc mật khẩu không đúng (admin/admin)']);
})->name('login.post');

// REGISTER & FORGOT PASSWORD
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

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

// DASHBOARD & PROTECTED ROUTES
Route::get('/dashboard', function() {
    if (!Session::get('authenticated')) {
        return redirect()->route('login');
    }
    return view('dashboard');
})->name('dashboard');

Route::get('/logout', function() {
    Session::forget('authenticated');
    Session::forget('user');
    return redirect()->route('login');
})->name('logout');

// Các route quản lý khác (Tạm thời bỏ middleware để bạn dễ test giao diện)
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);
Route::resource('users', UserController::class);
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
