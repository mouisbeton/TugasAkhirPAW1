<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-blue-600">Selamat Datang, {{ Auth::user()->name }}! 🎓</h3>
                    <p class="text-gray-600">Anda login sebagai Dosen Pengajar.</p>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
                    <h4 class="font-bold text-lg mb-2">📢 Buat Jarkoman Baru</h4>
                    <p class="text-sm text-gray-500 mb-4">Kirim pesan pengumuman ke Mahasiswa atau sesama rekan Dosen.</p>
                    
                    <a href="{{ route('messages.create') }}" class="block text-center bg-blue-600 text-white font-bold px-4 py-2 rounded hover:bg-blue-700 transition w-full shadow">
                        + Tulis Pesan
                    </a>
                    <a href="{{ route('messages.sent') }}" class="block text-center text-blue-600 text-sm font-semibold hover:underline mt-3">
                        📂 Lihat Riwayat / Tarik Pesan
                    </a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500 hover:shadow-md transition">
                    <h4 class="font-bold text-lg mb-2">📩 Kotak Masuk</h4>
                    <p class="text-sm text-gray-500 mb-4">Cek pesan masuk dari Akademik atau Dosen lain.</p>
                    
                    <a href="{{ route('messages.index') }}" class="block text-center bg-green-600 text-white font-bold px-4 py-2 rounded hover:bg-green-700 transition w-full shadow">
                        Lihat Pesan Masuk
                    </a>
                </div>
                
            </div>

        </div>
    </div>
</x-app-layout>