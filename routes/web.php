<?php

use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriCoaController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Dashboard
Route::get('/', [DashboardController::class,'index'])->name('dashboard.index');

// Kategori Coa
Route::get('/kategori-coa', [KategoriCoaController::class,'index'])->name('kategoriCoa.index');
Route::post('/kategori-coa', [KategoriCoaController::class, 'store'])->name('kategoriCoa.store');
Route::get('/kategori-coa/edit/{id}', [KategoriCoaController::class,'edit'])->name('kategoriCoa.edit');
Route::delete('kategori-coa/delete/{id}', [KategoriCoaController::class, 'destroy'])->name('kategoriCoa.delete');
Route::get('/kategori-coa/show/{id}', [KategoriCoaController::class, 'show'])->name('kategoriCoa.show');

// Chart OF Accounts
Route::get('/coa', [ChartOfAccountController::class, 'index'])->name('coa.index');
Route::post('/coa', [ChartOfAccountController::class, 'store'])->name('coa.store');
Route::get('/coa/edit/{id}',[ChartOfAccountController::class, 'edit'])->name('coa.edit');
Route::delete('/coa/delete/{id}', [ChartOfAccountController::class, 'destroy'])->name('coa.delete');
Route::get('coa/show/{id}', [ChartOfAccountController::class, 'show'])->name('coa.show');

// Transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi',[TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/edit/{id}', [TransaksiController::class,'edit'])->name('transaksi.edit');
Route::get('/transaksi/show/{id}', [TransaksiController::class,'show'])->name('transaksi.show');
Route::delete('/transaksi/delete/{id}', [TransaksiController::class,'destroy'])->name('transaksi.delete');
Route::get('transaksi/getDetail/{id}', [TransaksiController::class, 'getDetail'])->name('transaksi.getDetail');


// Export Excel Profit
Route::get('/export/excel', [DashboardController::class, 'export'])->name('export.excel');