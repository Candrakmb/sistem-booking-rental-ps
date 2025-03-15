<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\midauth;


Route::get('/', function () {
    return view('home');
});



Route::middleware([midauth::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
    Route::post('/getDataRentalSesi', [TransaksiController::class, 'getDataRental'])->name('getDataRental');
    Route::post('/calculateTotal', [TransaksiController::class, 'calculateTotal'])->name('calculateTotal');
    Route::post('/transaksi/create', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'detailTransaksi'])->name('transaksi.detail');
});

require __DIR__.'/auth.php';
