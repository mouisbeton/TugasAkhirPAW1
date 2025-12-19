@if(Auth::user()->role === 'dosen')

    @component('layouts.dosen-panel')

    <div class="h-full flex flex-col">
        
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Detail Pesan 📨</h1>
                <p class="text-gray-500 mt-1">Membaca isi pesan lengkap.</p>
            </div>
            
            <a href="{{ route('messages.index') }}" class="inline-flex items-center text-sm font-bold hover:underline transition" style="color: #9F3E28;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Inbox
            </a>
        </div>

        <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm flex-1 overflow-hidden flex flex-col relative">
            
            <div class="h-2 w-full bg-[#FEF2F2]"></div>

            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 border-b border-gray-100 pb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#FEF2F2] text-[#9F3E28] flex items-center justify-center font-bold text-xl shadow-sm border border-red-100">
                            {{ substr($message->sender->name ?? 'X', 0, 1) }}
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Pengirim</div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $message->sender->name ?? 'Pengguna Terhapus' }}</h3>
                            <span class="inline-block bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded font-bold uppercase mt-1">
                                {{ $message->sender->role ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="text-left md:text-right">
                        <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Waktu Diterima</div>
                        <div class="font-medium text-gray-700 text-lg">
                            {{ $message->created_at->format('l, d F Y') }}
                        </div>
                        <div class="text-sm text-gray-400">
                            Pukul {{ $message->created_at->format('H:i') }} WIB
                        </div>
                    </div>
                </div>

                <div class="max-w-4xl">
                    <div class="mb-6">
                        <span class="text-gray-400 text-sm font-bold uppercase tracking-wide">Perihal :</span>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2 leading-tight">
                            {{ $message->subject }}
                        </h2>
                    </div>

                    <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed bg-gray-50/50 p-8 rounded-2xl border border-gray-100">
                        {!! nl2br(e($message->body)) !!}
                    </div>
                </div>

            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('messages.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-white hover:shadow-sm transition border border-transparent hover:border-gray-200">
                    Kembali
                </a>

                <div class="flex items-center gap-3">
                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-white border border-red-100 text-red-600 font-bold rounded-xl hover:bg-red-50 transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Pesan
                        </button>
                    </form>

                    <a href="{{ route('messages.create') }}" class="px-6 py-3 text-white font-bold rounded-xl shadow-lg transition transform hover:scale-105 flex items-center gap-2" style="background-color: #9F3E28;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Balas
                    </a>
                </div>
            </div>

        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    </style>

    @endcomponent

@else

    @component('layouts.student-panel')

    <div class="max-w-4xl mx-auto space-y-6">
        
        <a href="{{ route('messages.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 transition font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Kotak Masuk
        </a>

        <div class="bg-white rounded-[30px] shadow-sm overflow-hidden p-8 min-h-[500px] relative">
            
            <div class="border-b border-gray-100 pb-6 mb-6 flex justify-between items-start">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center font-bold text-lg">
                        {{ substr($message->sender->name ?? 'X', 0, 1) }}
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800 text-lg">{{ $message->sender->name ?? 'Pengguna Terhapus' }}</h2>
                        <div class="text-sm text-gray-500">{{ $message->sender->role ?? '-' }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-700">{{ $message->created_at->format('d M Y') }}</div>
                    <div class="text-xs text-gray-400">{{ $message->created_at->format('H:i') }} WIB</div>
                </div>
            </div>

            <div class="mb-10">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $message->subject }}</h1>
                <div class="text-gray-700 leading-relaxed whitespace-pre-wrap font-serif text-lg">
                    {!! nl2br(e($message->body)) !!}
                </div>
            </div>

            <div class="absolute bottom-8 left-8 right-8 flex justify-between border-t border-gray-100 pt-6">
                <form action="{{ route('messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Pesan
                    </button>
                </form>
            </div>

        </div>
    </div>

    @endcomponent

@endif