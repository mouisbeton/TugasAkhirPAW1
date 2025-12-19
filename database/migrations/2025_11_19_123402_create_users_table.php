<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Pastikan baris 'role' ini SUDAH ADA (hasil perbaikan sebelumnya)
            $table->string('role')->default('mahasiswa'); 
            
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // --- TAMBAHKAN BARIS INI (Supaya error 'angkatan' hilang) ---
            $table->integer('angkatan')->nullable(); 
            // -----------------------------------------------------------
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};