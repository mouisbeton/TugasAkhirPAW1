<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('receiver_id', Auth::id())->with('sender')->latest()->get();
        return view('messages.index', compact('messages'));
    }

    // --- UPDATE 1: Ambil Data Angkatan ---
    public function create()
    {
        // Ambil daftar tahun angkatan yang ada di database (unik & urut dari terbaru)
        $angkatans = User::where('role', 'mahasiswa')
                         ->whereNotNull('angkatan')
                         ->distinct()
                         ->orderBy('angkatan', 'desc')
                         ->pluck('angkatan');

        return view('messages.create', compact('angkatans'));
    }

    // --- UPDATE 2: Logika Kirim Per Angkatan ---
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'receiver_role' => 'required|string',
            'angkatan' => 'nullable|string', // Validasi baru untuk angkatan
        ]);

        $senderId = Auth::id();

        // LOGIKA PENGIRIMAN
        if ($request->receiver_id) {
            // A. KASUS SPESIFIK (1 ORANG)
            Message::create([
                'sender_id' => $senderId,
                'receiver_id' => $request->receiver_id,
                'subject' => $request->subject,
                'body' => $request->body,
                'status' => 'unread',
            ]);
            $count = 1;

        } else {
            // B. KASUS BROADCAST
            $query = User::where('role', $request->receiver_role)
                         ->where('id', '!=', $senderId);

            // FILTER TAMBAHAN: JIKA MEMILIH ANGKATAN
            if ($request->receiver_role == 'mahasiswa' && $request->filled('angkatan')) {
                $query->where('angkatan', $request->angkatan);
            }

            $receivers = $query->get();

            foreach ($receivers as $receiver) {
                Message::create([
                    'sender_id' => $senderId,
                    'receiver_id' => $receiver->id,
                    'subject' => $request->subject,
                    'body' => $request->body,
                    'status' => 'unread',
                ]);
            }
            $count = $receivers->count();
        }

        return redirect()->route('dosen.dashboard')
            ->with('success', "Pesan berhasil dikirim ke $count orang!");
    }

    // ... (Fungsi sent, show, destroy biarkan tetap sama seperti sebelumnya) ...
    public function sent() { /* ... */ return view('messages.sent', compact('messages')); }
    public function show($id) { /* ... */ return view('messages.show', compact('message')); }
    public function destroy($id) { /* ... */ return back(); }
}