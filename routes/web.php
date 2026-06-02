<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\BarangMasukController;

Route::resource('kategori', KategoriController::class);
Route::resource('pengguna', PenggunaController::class);
Route::resource('barang_masuk', BarangMasukController::class);