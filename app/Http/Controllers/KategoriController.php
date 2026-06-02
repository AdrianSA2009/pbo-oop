<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Interfaces\Manageable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama'
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain!'
        ]);

        Kategori::create($validated);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama'
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain!'
        ]);
        $kategori->update($validated);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Kategori $kategori, $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            
            // M3: Memanggil metode delete() yang sudah di-override di Model.
            // Jika kategori masih memiliki barang, otomatis melempar Exception.
            $kategori->delete();

            $this->logActivity($kategori);

            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            // Menangkap pesan error dari model jika gagal dihapus
            return redirect()->route('kategori.index')->with('error', $e->getMessage());
        }
    }

    // M4: Polimorfisme Khusus. Method ini menerima objek APAPUN yang mengimplementasikan interface Manageable
    private function logActivity(Manageable $item)
    {
        // Memanggil method signature dari kontrak interface tanpa peduli ini kelas Kategori atau BarangMasuk
        Log::info($item->getLogActivityDetails());
    }
}