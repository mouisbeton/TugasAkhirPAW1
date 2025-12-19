<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DosenController extends Controller
{
    /**
     * Menampilkan daftar dosen.
     */
    public function index()
    {
        // Ambil semua user yang role-nya 'dosen'
        $dosens = User::where('role', 'dosen')->latest()->get();
        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Menampilkan form tambah dosen.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Menyimpan data dosen baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Simpan ke Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen', // Set role otomatis jadi dosen
            'angkatan' => null, // Dosen tidak punya angkatan, set null
            // 'department_id' => 1,  <-- INI YANG BIKIN ERROR, KITA HAPUS
        ]);

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit dosen.
     */
    public function edit($id)
    {
        $dosen = User::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    /**
     * Mengupdate data dosen.
     */
    public function update(Request $request, $id)
    {
        $dosen = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$dosen->id],
        ]);

        // Update data dasar
        $dosen->name = $request->name;
        $dosen->email = $request->email;

        // Jika password diisi, update passwordnya
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $dosen->password = Hash::make($request->password);
        }

        $dosen->save();

        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil diperbarui!');
    }

    /**
     * Menghapus data dosen.
     */
    public function destroy($id)
    {
        $dosen = User::findOrFail($id);
        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus!');
    }
}