<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Manageable;

class BarangMasuk extends Model implements Manageable
{
    use HasFactory;

    protected $table = 'barang_masuk';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'kode_transaksi', 
        'karyawan_id', 
        'supplier_id', 
        'barang_id', 
        'jumlah', 
        'tgl_masuk'
    ];

    public function getTanggalMasukFormatAttribute()
    {
        return \Carbon\Carbon::parse($this->tgl_masuk)->format('d-M-Y');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'karyawan_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function getLogActivityDetails(): string {
        return "Barang Masuk ID " . $this->id . " sejumlah " . $this->jumlah . " ditambahkan.";
    }
}