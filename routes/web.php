<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\midauth;


Route::get('/', function () {
    return view('home');
});



Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/getDataRentalSesi', [TransaksiController::class, 'getDataRental'])->name('getDataRental');
    Route::post('/calculateTotal', [TransaksiController::class, 'calculateTotal'])->name('calculateTotal');
    Route::post('/transaksi/create', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'detailTransaksi'])->name('transaksi.detail');
    Route::get('/transaksi/berhasil', [TransaksiController::class, 'pembayaranBerhasil'])->name('transaksi.berhasil');
    Route::get('/riwayat', [RiwayatController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat/detail/{id}', [RiwayatController::class, 'detailTransaksi'])->name('riwayat.detail');
});

Route::middleware('auth','role:admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
