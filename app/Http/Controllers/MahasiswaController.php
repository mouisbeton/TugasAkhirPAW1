<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar semua mahasiswa.
     */
    public function index()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->latest()->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Menampilkan form tambah mahasiswa.
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Menyimpan data mahasiswa baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'angkatan' => 'required|numeric',
            'password' => 'required|min:6',
        ]);

        // 2. Masukkan ke Database
        // SAYA SUDAH MENGHAPUS 'department_id' DI SINI AGAR TIDAK ERROR
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'angkatan' => $request->angkatan,
            'password' => Hash::make($request->password), // Password di-hash
            'role' => 'mahasiswa', // Role otomatis jadi mahasiswa
        ]);

        // 3. Kembali ke halaman tabel dengan pesan sukses
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail (biasanya tidak dipakai jika tabel sudah cukup).
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan form untuk edit data.
     */
    public function edit(string $id)
    {
        // Cari mahasiswa berdasarkan ID
        $mahasiswa = User::findOrFail($id);
        
        // Tampilkan view edit
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update data mahasiswa ke database.
     */
    public function update(Request $request, string $id)
    {
        $mahasiswa = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi email unik kecuali untuk user ini sendiri
            'email' => 'required|email|unique:users,email,'.$id, 
            'angkatan' => 'required|numeric',
            'password' => 'nullable|min:6', // Password boleh kosong jika tidak ingin diganti
        ]);

        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'angkatan' => $request->angkatan,
        ];

        // Jika password diisi, maka update password baru
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $mahasiswa->update($dataToUpdate);

        return redirect()->route('mahasiswa.index')->with('success', 'Data Mahasiswa berhasil diperbarui!');
    }

    /**
     * Hapus data mahasiswa.
     */
    public function destroy(string $id)
    {
        $mahasiswa = User::findOrFail($id);

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus!');
    }
}