<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Home -> role-based redirect
Route::get('/', [DashboardController::class, 'redirectByRole'])->name('dashboard.redirect');

// Dashboards
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    // Manage products
    Route::resource('products', ProductController::class);
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [ReportController::class, 'downloadPdf'])->name('reports.download');
    // Expenses
    Route::resource('expenses', ExpenseController::class)->only(['index','create','store','destroy']);
});

Route::middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/cashier', [DashboardController::class, 'cashier'])->name('dashboard.cashier');
    // Product lookup/catalog
    Route::get('/orders/catalog', [OrderController::class, 'catalog'])->name('orders.catalog');
    // Mark paid
    Route::post('/orders/{order}/paid', [OrderController::class, 'markPaid'])->name('orders.markPaid');
});

Route::middleware(['auth', 'role:admin,cashier,user'])->group(function () {
    Route::get('/user', [DashboardController::class, 'user'])->name('dashboard.user');
    // Shopping
    Route::get('/shop', [OrderController::class, 'catalog'])->name('shop.catalog');
    Route::post('/cart/add/{product}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [OrderController::class, 'cart'])->name('cart.view');
    Route::get('/checkout', [OrderController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
});
