@if(Auth::user()->role === 'dosen')

    @component('layouts.dosen-panel')

    <div class="h-full flex flex-col">
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Kotak Masuk 📬</h1>
                <p class="text-gray-500 mt-1">Daftar pesan dan notifikasi yang masuk ke akun Anda.</p>
            </div>
            
            <a href="{{ route('dosen.dashboard') }}" class="inline-flex items-center text-sm font-bold hover:underline transition" style="color: #9F3E28;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm flex-1 overflow-hidden flex flex-col">
            
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Pesan Masuk Terbaru</h3>
                    <p class="text-sm text-gray-400">Pesan dari Mahasiswa atau Akademik.</p>
                </div>
                
                @if($messages->count() > 0)
                <form action="{{ route('messages.destroyAll') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SEMUA pesan masuk?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 text-sm font-bold rounded-xl hover:bg-red-100 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Semua
                    </button>
                </form>
                @endif
            </div>

            <div class="overflow-x-auto flex-1 custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pengirim</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Subjek</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($messages as $index => $msg)
                        <tr class="hover:bg-[#FEF2F2]/40 transition duration-150 group">
                            <td class="px-6 py-4 text-sm text-gray-400 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-[#9F3E28] font-bold text-xs uppercase border border-orange-100">
                                        {{ substr($msg->sender->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $msg->sender->name ?? 'Unknown' }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase">{{ $msg->sender->role ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700 font-medium text-sm line-clamp-1 block max-w-xs group-hover:text-[#9F3E28] transition">
                                    {{ $msg->subject }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $msg->created_at->format('d M, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($msg->status == 'read')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-bold border border-gray-200">
                                        DIBACA
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#FEF2F2] text-[#9F3E28] text-[10px] font-bold border border-red-100 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#9F3E28]"></span>
                                        BARU
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('messages.show', $msg->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-[#9F3E28] hover:bg-orange-50 transition" title="Baca">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan?');">
                                        @csrf @method('DELETE')
                                        <button class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 text-sm font-medium">Belum ada pesan masuk.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    </style>

    @endcomponent

@else

    @component('layouts.student-panel')

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800">Kotak Masuk</h2>
            <div class="text-sm text-gray-500">Daftar Konsultasi & Pesan</div>
        </div>

        <div class="bg-white rounded-[30px] shadow-sm p-8 min-h-[500px]">
            
            <div class="grid grid-cols-12 gap-4 text-gray-400 font-bold text-xs uppercase tracking-wider pb-4 border-b-2 border-gray-100 mb-4">
                <div class="col-span-1 pl-2">No</div> 
                <div class="col-span-3">Pengirim</div>
                <div class="col-span-4">Subjek</div>
                <div class="col-span-2 text-center">Tanggal</div>
                <div class="col-span-1 text-center">Status</div>
                <div class="col-span-1 text-center">Aksi</div>
            </div>

            @forelse($messages as $index => $msg)
            <div onclick="window.location='{{ route('messages.show', $msg->id) }}'" 
                 class="grid grid-cols-12 gap-4 items-center text-gray-700 py-4 border-b border-gray-50 hover:bg-blue-50/50 transition duration-200 group cursor-pointer">
                
                <div class="col-span-1 font-bold text-gray-400 pl-2">
                    {{ $index + 1 }}
                </div>
                
                <div class="col-span-3 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-bold text-sm uppercase group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                        {{ substr($msg->sender->name, 0, 2) }}
                    </div>
                    <div>
                        <div class="font-bold text-sm text-gray-800 group-hover:text-blue-600 transition">{{ $msg->sender->name }}</div>
                        <div class="text-[10px] text-gray-400 uppercase">{{ $msg->sender->role }}</div>
                    </div>
                </div>
                
                <div class="col-span-4 text-sm font-medium pr-4 truncate group-hover:text-blue-600 transition">
                    {{ $msg->subject }}
                </div>
                
                <div class="col-span-2 text-center text-xs text-gray-500">
                    {{ $msg->created_at->format('d M Y') }}
                </div>
                
                <div class="col-span-1 text-center flex justify-center relative" onclick="event.stopPropagation()">
                    <div x-data="{ 
                            open: false, 
                            status: '{{ $msg->status ?? 'Berlangsung' }}',
                            updateStatus(newStatus) {
                                this.status = newStatus; 
                                this.open = false;
                                fetch('{{ route('messages.updateStatus', $msg->id) }}', {
                                    method: 'PATCH',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ status: newStatus })
                                });
                            }
                        }" 
                        class="relative">

                        <button @click="open = !open" 
                                class="flex items-center justify-between px-3 py-1.5 rounded-full text-[10px] font-bold transition-all min-w-[100px] shadow-sm border"
                                :class="status === 'Berlangsung' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-green-50 text-green-600 border-green-100'">
                            <span x-text="status"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" 
                             @click.outside="open = false"
                             style="display: none;"
                             class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden p-1">
                            
                            <button @click="updateStatus('Berlangsung')" class="w-full text-left px-3 py-2 text-xs font-bold text-blue-600 hover:bg-blue-50 rounded-lg transition flex items-center">
                                <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span> Berlangsung
                            </button>
                            <button @click="updateStatus('Selesai')" class="w-full text-left px-3 py-2 text-xs font-bold text-green-600 hover:bg-green-50 rounded-lg transition flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Selesai
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-span-1 text-center">
                    <a href="{{ route('messages.show', $msg->id) }}" class="text-blue-500 hover:text-blue-700 text-xs font-bold hover:underline">
                        Buka
                    </a>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-20 text-gray-400">
                <p class="text-lg font-medium">Belum ada pesan masuk.</p>
            </div>
            @endforelse

        </div>
    </div>
    @endcomponent

@endif