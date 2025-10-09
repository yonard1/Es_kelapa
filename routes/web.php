<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MaterialController,
    ProductController,
    AuthController,
    UserController,
    PembelianController,
    TransaksiController,
    DashboardController
};

// ===================== HALAMAN UMUM =====================
Route::get('/', fn() => view('welcome'))->name('home');

// ==================
// Auth (Login & Register)
// ==================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================
// Dashboard (Admin & Kasir)
// ==================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/kasir/dashboard', [DashboardController::class, 'index'])
        ->name('kasir.dashboard');
});

// ==================
// CRUD & Modul Aplikasi
// ==================
Route::middleware(['auth'])->group(function () {

    // Produk
    Route::resource('product', ProductController::class);

    // Bahan/material
    Route::resource('material', MaterialController::class);

    // Pembelian
    Route::resource('pembelian', PembelianController::class);

    // Transaksi + Struk
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/{id}/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');
});

// ==================
// Admin Only
// ==================
Route::middleware(['auth', 'admin'])->group(function () {
    // CRUD User (khusus admin)
    Route::resource('users', UserController::class);
});

