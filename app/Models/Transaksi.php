<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'barang_id',
        'jumlah',
        'tanggal',
    ];

    /**
     * Relasi ke class/tabel Barang
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'Kode_Barang');
    }

    /**
     * Relasi ke class/tabel Pengguna
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'user_id', 'id');
    }
}