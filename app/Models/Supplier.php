<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Manageable; // M4: Import Interface

class Supplier extends Model implements Manageable
{
    // M2: Enkapsulasi data melalui properti fillable
    protected $fillable = ['nama_supplier', 'alamat', 'telepon'];

    /**
     * Relasi One-to-Many ke BarangMasuk
     */
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'supplier_id');
    }

    /**
     * M3: Overriding metode delete() bawaan Eloquent
     */
    public function delete()
    {
        // Proteksi: Cek apakah supplier ini sudah pernah memasok barang masuk
        if ($this->barangMasuk()->count() > 0) {
            throw new \Exception("Supplier tidak dapat dihapus karena memiliki riwayat transaksi barang masuk!");
        }

        return parent::delete();
    }

    /**
     * M4: Implementasi kontrak getLogActivityDetails (Polimorfisme)
     */
    public function getLogActivityDetails(): string
    {
        return "Data Supplier: " . $this->nama_supplier . " telah diperbarui/dimanipulasi.";
    }
}