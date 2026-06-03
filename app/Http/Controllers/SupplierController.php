<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Interfaces\Manageable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier.
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Menyimpan data supplier baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat'        => 'required|string',
            'telepon'       => 'required|string|max:15',
        ]);

        // M2: Membuat objek baru terenkapsulasi
        $supplier = Supplier::create($request->all());

        // M4: Polimorfisme mencatat aktivitas ke log teks
        $this->logActivity($supplier);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Menghapus data supplier dengan proteksi OOP.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            // M3: Mengeksekusi delete() yang sudah di-override di dalam Model
            $supplier->delete();

            // M4: Polimorfisme mencatat log penghapusan sukses
            $this->logActivity($supplier);

            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
        } catch (\Exception $e) {
            // Menangkap pesan exception dari model jika aturan bisnis dilanggar
            return redirect()->route('supplier.index')->with('error', $e->getMessage());
        }
    }

    /**
     * M4: Metode Polimorfisme Khusus
     * Menerima objek apa saja yang mengimplementasikan aturan 'Manageable'
     */
    private function logActivity(Manageable $item)
    {
        Log::info($item->getLogActivityDetails());
    }
}