<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MessageController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- MODIFIKASI UTAMA DI SINI ---
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('dashboard'); // Ke Admin Panel
        } elseif ($role === 'dosen') {
            return redirect()->route('dosen.dashboard'); // Ke Dosen Panel
        } else {
            // Mahasiswa default ke Kotak Masuk (sesuai requestmu sebelumnya)
            return redirect()->route('messages.index'); 
        }
    }
    return view('welcome');
});
// --------------------------------

// --- GROUP 1: KHUSUS ADMIN ---
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Ini Dashboard ADMIN (Link: /dashboard)
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('dosen', DosenController::class);
});

// --- GROUP 2: UNTUK USER LOGIN (Dosen & Mahasiswa) ---
Route::middleware('auth')->group(function () {

    // 1. Dashboard MAHASISWA (Link: /student-dashboard)
    Route::get('/student-dashboard', function () {
        // Opsional: Cek biar Dosen/Admin gak salah masuk sini
        if (Auth::user()->role !== 'mahasiswa') {
             return redirect()->back();
        }
        // Jika kamu mau dashboard mahasiswa juga langsung ke pesan, 
        // ganti return view(...) dengan: return redirect()->route('messages.index');
        return view('student.dashboard'); 
    })->name('student.dashboard');

    // 2. Dashboard DOSEN (Link: /dosen-dashboard)
    Route::get('/dosen-dashboard', function () {
        if (Auth::user()->role !== 'dosen') {
            abort(403, 'Halaman ini khusus Dosen');
        }
        return view('dosen.dashboard'); 
    })->name('dosen.dashboard');

    // 3. Fitur Pesan / Jarkoman
    Route::get('/pesan/buat', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/pesan/kirim', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/pesan/masuk', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/pesan/baca/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/pesan/terkirim', [MessageController::class, 'sent'])->name('messages.sent');
    Route::delete('/pesan/hapus-semua', [MessageController::class, 'destroyAll'])->name('messages.destroyAll');
    Route::delete('/pesan/hapus/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // 4. Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   Route::get('/kalender', function () {
        
        $messages = \App\Models\Message::where('receiver_id', Auth::id())->get();

        $events = $messages->map(function($msg) {
            return [
                'title'  => $msg->subject,
                'date'   => $msg->created_at->format('Y-m-d'), 
                'type'   => 'Pesan Masuk',
                // TAMBAHAN PENTING: Kita kirim statusnya juga
                'status' => $msg->status ?? 'Berlangsung' 
            ];
        });

        return view('kalender', ['events' => $events]);

    })->name('kalender');

    // Route untuk update status pesan (AJAX)
    Route::patch('/pesan/{id}/update-status', [App\Http\Controllers\MessageController::class, 'updateStatus'])->name('messages.updateStatus');

});

require __DIR__.'/auth.php';