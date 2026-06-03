<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\SupplierController;

Route::resource('kategori', KategoriController::class);
Route::resource('pengguna', PenggunaController::class);
Route::resource('barang_masuk', BarangMasukController::class);
Route::resource('barang_keluar', BarangKeluarController::class);
Route::resource('supplier', SupplierController::class);