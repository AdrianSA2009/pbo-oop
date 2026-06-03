<?php

namespace App\Models;

use App\Interfaces\Manageable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasuk extends Transaksi implements Manageable
{
    protected $table = 'barang_masuk';

    public function initializeBarangMasuk()
    {
        $this->fillable[] = 'supplier_id';
    }

    /**
     * Relasi ke class/tabel Supplier
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function getTanggalMasukFormatAttribute(): string
    {
        return \Carbon\Carbon::parse($this->tanggal)->format('d F Y');
    }

    public function getLogActivityDetails(): string
    {
        return "Barang Masuk diproses. Kode: {$this->kode_transaksi}, Jumlah: {$this->jumlah}.";
    }
}