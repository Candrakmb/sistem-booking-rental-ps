<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SesiController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/rental/table', [RentalController::class, 'index'])->name('rental.table');
    Route::get('/rental/create', [RentalController::class, 'create'])->name('rental.create');
    Route::get('/rental/edit/{id}', [RentalController::class, 'edit'])->name('rental.edit');
    Route::post('/rental/formcreate', [RentalController::class, 'store'])->name('rental.formcreate');
    Route::post('/rental/formupdate', [RentalController::class, 'update'])->name('rental.formupdate');
    Route::get('/rental/delete/{id}', [RentalController::class, 'destroy'])->name('rental.delete');
    
    Route::get('/sesi/table', [SesiController::class, 'index'])->name('sesi.table');
    Route::get('/sesi/create', [SesiController::class, 'create'])->name('sesi.create');
    Route::get('/sesi/edit/{id}', [SesiController::class, 'edit'])->name('sesi.edit');
    Route::post('/sesi/formcreate', [SesiController::class, 'store'])->name('sesi.formcreate');
    Route::post('/sesi/formupdate', [SesiController::class, 'update'])->name('sesi.formupdate');
    Route::get('/sesi/delete/{id}', [SesiController::class, 'destroy'])->name('sesi.delete');

    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/report/detail/{id}', [ReportController::class, 'detailTransaksi'])->name('report.detail');
});

require __DIR__.'/auth.php';
