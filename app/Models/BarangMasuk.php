<?php

namespace App\Models;

use App\Interfaces\Manageable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasuk extends Transaksi implements Manageable
{
    protected $table = 'barang_masuk';

    public function __construct(array $attributes = [])
    {
        // Tambahkan atribut spesifik child ke dalam fillable parent
        $this->fillable = array_merge($this->fillable, ['supplier_id']);
        
        parent::__construct($attributes);
    }

    /**
     * Relasi ke class/tabel Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
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