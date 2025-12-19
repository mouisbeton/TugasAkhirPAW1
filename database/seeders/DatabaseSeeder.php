<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@filkom.ub.ac.id',
            'role' => 'admin',  // JANGAN 'role_id', TAPI 'role'
            'password' => Hash::make('123456'),
        ]);

        // 2. Buat Akun DOSEN
        User::create([
            'name' => 'Pak Dosen',
            'email' => 'dosen@filkom.ub.ac.id',
            'role' => 'dosen', // Pakai teks string
            'password' => Hash::make('123456'),
        ]);

        // 3. Buat Akun MAHASISWA
        User::create([
            'name' => 'Budi Mahasiswa',
            'email' => 'budi@student.ub.ac.id',
            'role' => 'mahasiswa', // Pakai teks string
            'password' => Hash::make('123456'),
            'angkatan' => 2024, // Pastikan kolom angkatan ada di migration jika mau dipakai, kalau error hapus baris ini
        ]);
    }
}