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
    LaporanController,
    ProduksiController
};

// ===== HALAMAN UMUM =====
Route::get('/', fn() => view('welcome'))->name('home');

// ===== AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== DASHBOARD =====
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/kasir/dashboard', [DashboardController::class, 'index'])->name('kasir.dashboard');
    Route::get('/dashboard/material-stok', [DashboardController::class, 'getMaterialStok'])->name('get.material.stok');
    Route::get('/get-top-products', [DashboardController::class, 'getTopProducts'])->name('get.top.products');
});

// ===== ADMIN ONLY =====
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('product', ProductController::class);
    Route::resource('material', MaterialController::class);
    Route::resource('users', UserController::class);

    Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
    Route::post('/produksi', [ProduksiController::class, 'store'])->name('produksi.store');
    Route::delete('/produksi/{id}', [ProduksiController::class, 'destroy'])->name('produksi.destroy');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/download', [LaporanController::class, 'downloadPdf'])->name('laporan.download');
});

// ===== ADMIN & KASIR =====
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    // Pembelian
    Route::resource('pembelian', PembelianController::class);

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

    // Riwayat transaksi (khusus kasir)
    Route::get('/kasir/riwayat', [TransaksiController::class, 'riwayat'])->name('kasir.riwayat')->middleware('role:kasir');
});
