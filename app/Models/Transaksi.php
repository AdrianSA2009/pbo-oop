<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'karyawan_id',
        'barang_id',
        'jumlah',
        'tgl_masuk',
    ];

    public $timestamps = false;

    /**
     * Relasi ke class/tabel Barang
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * Relasi ke class/tabel Pengguna
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'karyawan_id');
    }
}