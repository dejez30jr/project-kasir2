<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MediaController;

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Landing page (default homepage) — show only for guests
Route::get('/', function(){
    if (Auth::check()) {
        return redirect()->route('dashboard.redirect');
    }
    return view('landing');
})->name('landing');
// Role-based redirect homepage for authenticated users
Route::get('/home', [DashboardController::class, 'redirectByRole'])->name('dashboard.redirect');

// Media proxy for public storage (bypass OS symlink requirements)
Route::get('/media/{path}', [MediaController::class, 'show'])->where('path', '.*')->name('media.show');

// Dashboards
// Shared product abilities: admin + cashier dapat melihat, menambah, mengedit, dan menghapus produk
Route::middleware(['auth', 'role:admin,cashier'])->group(function () {
    Route::resource('products', ProductController::class)->only(['index','create','store','edit','update','destroy']);
    Route::get('products/{product}/stock-in', [ProductController::class, 'stockForm'])->name('products.stock.form');
    Route::post('products/{product}/stock-in', [ProductController::class, 'stockIn'])->name('products.stock.store');
});

// Admin-only area
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    // (produk destroy sudah di-share di grup admin+cashier)
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [ReportController::class, 'downloadPdf'])->name('reports.download');
    // Expenses
    Route::resource('expenses', ExpenseController::class)->only(['index','create','store','destroy']);

    // User management (admin only)
    Route::resource('users', \App\Http\Controllers\UserManagementController::class)
        ->only(['index','create','store','edit','update','destroy'])
        ->parameters(['users' => 'user']);
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\UserManagementController::class, 'resetPassword'])
        ->name('users.reset');
});

Route::middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/cashier', [DashboardController::class, 'cashier'])->name('dashboard.cashier');
    // Product lookup/catalog
    Route::get('/orders/catalog', [OrderController::class, 'catalog'])->name('orders.catalog');
});

// Admin + Cashier can confirm payments
Route::middleware(['auth', 'role:admin,cashier'])->group(function () {
    Route::post('/orders/{order}/paid', [OrderController::class, 'markPaid'])->name('orders.markPaid');
});

Route::middleware(['auth', 'role:admin,cashier,user'])->group(function () {
    Route::get('/user', [DashboardController::class, 'user'])->name('dashboard.user');
    // Shopping
    Route::get('/shop', [OrderController::class, 'catalog'])->name('shop.catalog');
    Route::post('/cart/add/{product}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [OrderController::class, 'cart'])->name('cart.view');
    Route::post('/cart/update/{product}', [OrderController::class, 'updateCart'])->name('cart.update');
    // Scan barcode/SKU to add to cart
    Route::post('/cart/scan', [OrderController::class, 'scanAdd'])->name('cart.scan');
    Route::post('/cart/clear', [OrderController::class, 'clearCart'])->name('cart.clear');
    Route::get('/checkout', [OrderController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
});
