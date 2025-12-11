<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesan Terkirim') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Riwayat Jarkoman Anda</h3>
                            <a href="{{ route('dosen.dashboard') }}" class="text-sm text-blue-600 hover:underline inline-flex items-center mt-1">
                                &larr; Kembali ke Dashboard
                            </a>
                        </div>

                        @if($messages->count() > 0)
                        <form action="{{ route('messages.destroyAll') }}" method="POST" onsubmit="return confirm('PERINGATAN KERAS:\n\nApakah Anda yakin ingin menarik SEMUA pesan?\n\n1. Semua pesan di Inbox penerima akan hilang.\n2. Riwayat Anda akan kosong.\n3. Tindakan ini TIDAK BISA dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-700 transition flex items-center text-sm">
                                🗑️ Tarik Semua Pesan
                            </button>
                        </form>
                        @endif
                    </div>

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Kepada</th>
                                    <th class="py-3 px-6 text-left">Subjek</th>
                                    <th class="py-3 px-6 text-center">Dikirim Pada</th>
                                    <th class="py-3 px-6 text-center">Status Baca</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($messages as $msg)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left">
                                        <span class="font-bold text-gray-800">{{ $msg->receiver->name }}</span> <br>
                                        <span class="text-xs text-gray-400">({{ ucfirst($msg->receiver->role) }})</span>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $msg->subject }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        {{ $msg->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if($msg->is_read)
                                            <span class="bg-green-100 text-green-700 py-1 px-2 rounded-full text-xs font-bold">✔ Dibaca</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 py-1 px-2 rounded-full text-xs">Belum Dibaca</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <form action="{{ route('messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menarik pesan ini? Pesan akan hilang dari inbox penerima.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 text-red-600 px-3 py-1 rounded-full hover:bg-red-100 text-xs font-bold transition border border-red-200">
                                                🗑️ Tarik
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-400 bg-gray-50 rounded">
                                        <p class="mb-2">📭</p>
                                        Belum ada riwayat pesan terkirim.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>