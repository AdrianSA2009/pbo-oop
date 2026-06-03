<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Interfaces\Manageable;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Log;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barang_masuk = BarangMasuk::with(['pengguna', 'supplier', 'barang'])->get();

        $users = \App\Models\Pengguna::all();
        $suppliers = \App\Models\Supplier::all();
        $products = \App\Models\Barang::all();

        return view('barang_masuk.index', compact('barang_masuk', 'users', 'suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_transaksi' => 'required|string|unique:barang_masuk,kode_transaksi',
            'karyawan_id'        => 'required|exists:karyawan,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'barang_id'     => 'required|exists:barang,id',
            'jumlah'         => 'required|integer|min:1',
            'tgl_masuk'  => 'required|date'
        ]);

        $barangMasuk = BarangMasuk::create($validatedData);
        $this->logActivity($barangMasuk);

        $product = Barang::find($request->barang_id);
        if ($product) {
            $product->stok += $request->jumlah;
            $product->save();
        }

        return redirect()->route('barang_masuk.index')
                         ->with('success', 'Transaksi Barang Masuk berhasil dicatat dan stok diperbarui.');
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $validatedData = $request->validate([
            'karyawan_id'       => 'required|exists:karyawan,id',
            'supplier_id'   => 'required|exists:suppliers,id',
            'barang_id'    => 'required|exists:barang,id',
            'jumlah'        => 'required|integer|min:1',
            'tgl_masuk' => 'required|date'
        ]);

        $product = Barang::find($barangMasuk->barang_id);
        if ($product) {
            $product->stok -= $barangMasuk->jumlah;
            $product->stok += $request->jumlah;
            $product->save();
        }

        $barangMasuk->update($validatedData);
        $this->logActivity($barangMasuk);

        return redirect()->route('barang_masuk.index')
                         ->with('success', 'Data transaksi barang masuk berhasil diperbarui.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        $product = Barang::find($barangMasuk->barang_id);
        if ($product) {
            $product->stok -= $barangMasuk->jumlah;
            $product->save();
        }

        $barangMasuk->delete();
        $this->logActivity($barangMasuk);

        return redirect()->route('barang_masuk.index')
                         ->with('success', 'Transaksi berhasil dihapus dan penyesuaian stok dilakukan.');
    }

    // Implementasi polimorfisme Interface Manageable
    private function logActivity(Manageable $item)
    {
        Log::info($item->getLogActivityDetails());
    }
}