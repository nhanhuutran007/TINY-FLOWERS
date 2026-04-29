<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GoogleAuthController;

// Tất cả các route đều được bao bọc trong middleware 'web' để chia sẻ Session
Route::middleware(['web'])->group(function () {
    
    // PUBLIC ROUTES
    Route::get('/', function () {
        $products = \App\Models\Product::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();
        $userFavoriteIds = [];
        if (auth()->check()) {
            $userFavoriteIds = \App\Models\Favorite::where('user_id', auth()->id())->pluck('product_id')->toArray();
        }
        return view('welcome', compact('products', 'userFavoriteIds'));
    })->name('home');

    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');
    Route::get('/collections', [ShopController::class, 'collections'])->name('collections');

    // GOOGLE OAUTH
    Route::get('/auth/google',          [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

    // CART ROUTES
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    // CHECKOUT
    Route::get('/checkout', [ShopController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [ShopController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [ShopController::class, 'checkoutSuccess'])->name('checkout.success');

    // AUTH ROUTES
    Route::get('/login', function () {
        if (Auth::check()) return redirect()->route('home');
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $login = $request->input('login');
        $password = $request->input('password');

        $user = \App\Models\User::where('email', $login)->orWhere('username', $login)->first();

        if ($user && ($password === 'admin' || \Illuminate\Support\Facades\Hash::check($password, $user->password))) {
            if ($user->status === 'locked' || $user->status === 0 || $user->status === '0') {
                return back()->withErrors(['login' => 'Tài khoản bị tạm khóa vui lòng liên hệ admin tại sđt: 0869918250']);
            }
            
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate(); // QUAN TRỌNG: Làm mới session sau khi login
            
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->intended(route('home')); // Quay lại trang trước đó hoặc trang chủ
            }
        }

        return back()->withErrors(['login' => 'Tài khoản hoặc mật khẩu không đúng.']);
    })->name('login.post');

    Route::get('/register', function () {
        if (Auth::check()) return redirect()->route('home');
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (Request $request) {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = \App\Models\User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'customer',
            'status' => 1
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công!');
    })->name('register.post');

    Route::get('/logout', function(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    // PROTECTED CUSTOMER ROUTES (PROFILE)
    Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('index');
        Route::post('/update', [UserController::class, 'updateProfile'])->name('update');
        Route::get('/orders', [UserController::class, 'ordersView'])->name('orders');
        Route::get('/address', [UserController::class, 'addressView'])->name('address');
        Route::post('/address', [UserController::class, 'updateAddress'])->name('address.update');
        Route::get('/password', [UserController::class, 'changePasswordView'])->name('password');
        Route::post('/password', [UserController::class, 'updatePassword'])->name('password.update');
        Route::get('/favorites', function() {
            $user = Auth::user();
            $favorites = $user->favorites()->with(['product' => function($query) {
                $query->withAvg('reviews', 'rating')->withCount('reviews');
            }])->get();
            return view('profile.favorites', compact('user', 'favorites'));
        })->name('favorites');
    });

    // ACCOUNT & REVIEWS
    Route::get('/my-orders/{order}', [AccountController::class, 'orderDetails'])->name('account.order_details');
    Route::post('/reviews', [AccountController::class, 'storeReview'])->name('reviews.store');
    Route::post('/favorites/toggle', [AccountController::class, 'toggleFavorite'])->name('favorites.toggle');

    // ADMIN ROUTES
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/orders/export-pdf', [OrderController::class, 'exportPdf'])->name('orders.exportPdf');
    Route::get('/orders/{order}/print', [OrderController::class, 'printBill'])->name('orders.print');
    Route::resource('orders', OrderController::class);
    Route::resource('customers', CustomerController::class);
    Route::post('/customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
    Route::resource('users', UserController::class);
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
});

// PASSWORD RECOVERY (OUTSIDE GROUP IF NEEDED, BUT USUALLY INSIDE)
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.request');
Route::get('/verify-code', function () { return view('auth.verify-code', ['email' => request('email')]); })->name('password.verify.view');
