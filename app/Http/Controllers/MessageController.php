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
        $messages = Message::where('receiver_id', Auth::id())
                            ->with('sender')
                            ->latest()
                            ->get();

        return view('messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = Message::where('id', $id)
                          ->where(function($query) {
                              $query->where('receiver_id', Auth::id())
                                    ->orWhere('sender_id', Auth::id());
                          })
                          ->firstOrFail();

        if ($message->receiver_id == Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('messages.show', compact('message'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'dosen') {
            abort(403, 'Hanya Dosen yang boleh mengirim pesan.');
        }

        $dosen = User::where('role', 'dosen')->where('id', '!=', Auth::id())->get();
        
        $angkatan = User::where('role', 'mahasiswa')
                        ->select('angkatan')
                        ->distinct()
                        ->orderBy('angkatan', 'desc')
                        ->pluck('angkatan');

        return view('dosen.messages.create', compact('dosen', 'angkatan'));
    }

    // 4. Proses Kirim Pesan (Broadcast Logic)
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'target_type' => 'required|in:dosen,mahasiswa',
        ]);

        $sender_id = Auth::id();
        $target_ids = [];

        if ($request->target_type == 'dosen') {
            $request->validate(['dosen_ids' => 'required|array']);
            $target_ids = $request->dosen_ids;
        } elseif ($request->target_type == 'mahasiswa') {
            $query = User::where('role', 'mahasiswa');
            if ($request->angkatan && $request->angkatan != 'all') {
                $query->where('angkatan', $request->angkatan);
            }
            $target_ids = $query->pluck('id')->toArray();
            
            if (empty($target_ids)) {
                return back()->withErrors(['msg' => 'Tidak ada mahasiswa ditemukan.']);
            }
        }

        foreach ($target_ids as $receiver_id) {
            Message::create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'subject' => $request->subject,
                'content' => $request->content,
                'is_read' => false,
            ]);
        }

        return redirect()->route('dosen.dashboard')->with('success', 'Pesan berhasil dikirim!');
    }

    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())
                            ->with('receiver') // Load nama penerima
                            ->latest()
                            ->get();

        return view('messages.sent', compact('messages'));
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menghapus pesan ini.');
        }

        $message->delete();

        return back()->with('success', 'Pesan berhasil ditarik/dihapus.');
    }

    public function destroyAll()
    {
        Message::where('sender_id', Auth::id())->delete();

        return back()->with('success', 'Semua riwayat pesan berhasil ditarik/dihapus.');
    }
}