<?php

namespace App\Http\Controllers;

use App\Models\Barang_Keluar;
use App\Interfaces\Manageable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BarangKeluarController extends Controller
{
    /**
     * Menampilkan daftar transaksi barang keluar.
     */
    public function index()
    {
        // Mengambil data barang keluar beserta relasinya menggunakan Eager Loading
        $barangKeluar = Barang_Keluar::with(['barang', 'karyawan'])->latest()->get();
        
        return view('barang_keluar.index', compact('barangKeluar'));
    }

    /**
     * Menyimpan data transaksi barang keluar baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input data sesuai dengan aturan integritas database
        $request->validate([
            'kode_transaksi' => 'required|unique:barang_keluar,kode_transaksi',
            'karyawan_id'    => 'required|exists:karyawan,id',
            'barang_id'      => 'required|exists:barang,id',
            'jumlah'         => 'required|integer|min:1',
            'tgl_keluar'     => 'required|date',
        ]);

        // M2: Enkapsulasi - Pembuatan objek dilakukan secara teratur melalui Mass Assignment di Model
        $barangKeluar = Barang_Keluar::create($request->all());

        // M4: Polimorfisme - Otomatis mencatat log jika model menerapkan Interface Manageable
        if ($barangKeluar instanceof Manageable) {
            $this->logActivity($barangKeluar);
        }

        return redirect()->route('barang_keluar.index')->with('success', 'Data barang keluar berhasil dicatat.');
    }

    /**
     * M4: Polimorfisme Khusus (Type Hinting Interface)
     * Method ini menerima objek apa pun selama mematuhi kontrak dari Manageable Interface
     */
    private function logActivity(Manageable $item)
    {
        // Memanggil signature method tanpa peduli apakah ini objek BarangMasuk, Kategori, atau BarangKeluar
        Log::info($item->getLogActivityDetails());
    }
}