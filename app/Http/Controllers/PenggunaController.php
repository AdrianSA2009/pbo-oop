<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::all();
        return view('pengguna.index', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:karyawan,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin_gudang,manajer'
        ], [
            'username.unique' => 'Username ini sudah terdaftar!',
        ]);

        Pengguna::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->role,
        ]);
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:karyawan,username,'.$pengguna->id,
            'role' => 'required|in:admin_gudang,manajer'
        ], [
            'username.unique' => 'Username ini sudah terdaftar!',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = $request->password;
        }

        $pengguna->update($validatedData);
        return redirect()->route('pengguna.index')->with('success', 'Data Pengguna berhasil diperbarui.');
    }

    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}