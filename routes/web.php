<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('mahasiswa', MahasiswaController::class);

    Route::resource('dosen', DosenController::class);
});

Route::middleware('auth')->group(function () {

    Route::get('/student-dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/pesan/buat', [App\Http\Controllers\MessageController::class, 'create'])->name('messages.create');
    Route::post('/pesan/kirim', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/pesan/masuk', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/pesan/baca/{id}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::get('/pesan/terkirim', [App\Http\Controllers\MessageController::class, 'sent'])->name('messages.sent');
    Route::delete('/pesan/hapus-semua', [App\Http\Controllers\MessageController::class, 'destroyAll'])->name('messages.destroyAll');
    Route::delete('/pesan/hapus/{id}', [App\Http\Controllers\MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/dosen-dashboard', function () {
        if (!auth()->user()->isDosen()) {
            abort(403, 'Khusus Dosen');
        }
        return view('dosen.dashboard'); 
    })->name('dosen.dashboard');
});
require __DIR__.'/auth.php';