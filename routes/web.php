<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KeretaController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\StasiunController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\PageController;

// Route untuk halaman kebijakan privasi
Route::get('/pages/kebijakan-privasi', [PageController::class, 'privacyPolicy'])->name('privacy.policy');

// Route untuk halaman panduan pemesanan tiket kereta
Route::get('/pages/panduan-pemesanan', [PageController::class, 'panduanPemesanan'])->name('panduan.pemesanan');

// Route untuk halaman pemesanan tiket kereta
Route::get('/pemesanans/{id}/print', [PemesananController::class, 'print'])->name('pemesanans.print');

// Route untuk halaman utama (home) sebelum login atau untuk user biasa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute khusus pencarian jadwal kereta
Route::get('/jadwals/search', [JadwalController::class, 'search'])->name('jadwals.search');

// Resource Controller Jadwal
Route::resource('jadwals', JadwalController::class);

// Authentication Routes
Auth::routes();

// Route untuk redirect user setelah login sesuai role
Route::get('/home', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    }
    return redirect('/login');
})->name('home.redirect');

// Group route untuk admin
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    Route::resource('stasiuns', StasiunController::class);
    Route::resource('keretas', KeretaController::class);
    Route::resource('rutes', RuteController::class);
    Route::resource('pemesanans', PemesananController::class);
    Route::resource('tikets', TiketController::class);
});

// Group route untuk user
Route::middleware(['auth', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('userspemesanans/create', [PemesananController::class, 'usercreate'])->name('pemesanans.users.create');
    Route::post('userspemesanans/', [PemesananController::class, 'userstore'])->name('pemesanans.users.store');
    Route::get('userspemesanans/payment', [PemesananController::class, 'userpayment'])->name('pemesanans.users.payment');
    Route::get('userspemesanans/invoice', [PemesananController::class, 'userinvoice'])->name('pemesanans.users.invoice');
});
