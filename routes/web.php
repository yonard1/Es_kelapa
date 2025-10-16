<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MaterialController,
    ProductController,
    AuthController,
    UserController,
    PembelianController,
    TransaksiController,
    DashboardController,
    LaporanController
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
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/kasir/dashboard', [DashboardController::class, 'index'])->name('kasir.dashboard');
});

// ==================
// Modul Umum (Bisa dipakai dua-duanya)
// ==================
Route::middleware(['auth'])->group(function () {
    Route::resource('product', ProductController::class);
    Route::resource('material', MaterialController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');
});

// ==================
// Admin Only
// ==================
Route::middleware(['auth', 'admin'])->group(function () {
    // 🔹 Daftar Transaksi (khusus admin)
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

    // 🔹 Tambah Transaksi
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

    // 🔹 Laporan & User
    Route::resource('users', UserController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

// ==================
// Kasir Only
// ==================
Route::middleware(['auth', 'kasir'])->group(function () {
    // 🔹 Transaksi baru
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

    // 🔹 Riwayat transaksi kasir
    Route::get('/kasir/riwayat', [TransaksiController::class, 'riwayat'])->name('kasir.riwayat');

    // 🔹 Cetak struk (hanya jika transaksi milik dia)
    Route::get('/transaksi/{id}/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');
});
