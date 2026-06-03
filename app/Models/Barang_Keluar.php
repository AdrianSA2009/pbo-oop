<?php

namespace App\Models;

use App\Interfaces\Manageable;

class BarangKeluar extends Transaksi implements Manageable
{
    protected $table = 'barang_keluar';

    public function initializeBarangKeluar()
    {
        $this->fillable[] = 'penerima';
    }

    /**
     * Contoh method custom tambahan sesuai diagram
     */
    public function unitBarang()
    {
        // Logika untuk mengecek atau mengambil spesifikasi unit barang
        return $this->barang->deskripsi ?? 'Unit tidak diketahui';
    }

    /**
     * Implementasi wajib dari interface Manageable
     */
    public function getLogActivityDetails(): string
    {
        return "Barang Keluar diserahkan kepada: {$this->penerima}. Kode: {$this->kode_transaksi}.";
    }
}