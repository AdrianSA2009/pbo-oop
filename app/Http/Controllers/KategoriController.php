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

        $kategori = Kategori::create($validated);
        $this->logActivity($kategori);
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
        $this->logActivity($kategori);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Kategori $kategori)
    {
        try {
            
            $kategori->delete();
            $this->logActivity($kategori);

            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            dd("Gagal menghapus! Alasan: " . $e->getMessage());
            return redirect()->route('kategori.index')->with('error', $e->getMessage());
        }
    }

    // Polimorfisme mengimplementasikan interface Manageable
    private function logActivity(Manageable $item)
    {
        Log::info($item->getLogActivityDetails());
    }
}