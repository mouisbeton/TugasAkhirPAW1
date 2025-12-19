@component('layouts.dosen-panel')

<div class="h-full flex flex-col">
    
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Buat Pengumuman 📣</h1>
            <p class="text-gray-500 mt-1">Kirim pesan spesifik per angkatan atau broadcast umum.</p>
        </div>
        <a href="{{ route('dosen.dashboard') }}" class="inline-flex items-center text-sm font-bold hover:underline transition" style="color: #9F3E28;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm flex-1 overflow-hidden flex flex-col">
        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            
            <form action="{{ route('messages.store') }}" method="POST" class="space-y-6 max-w-5xl mx-auto">
                @csrf

                <div class="bg-[#FEF2F2] rounded-2xl p-6 border border-red-100 transition-all duration-300">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-[#9F3E28] text-white flex items-center justify-center text-xs">1</span>
                        Target Penerima
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <label class="cursor-pointer relative group">
                            <input type="radio" name="receiver_role" value="dosen" class="peer sr-only" checked onclick="toggleOptions('dosen')">
                            <div class="p-4 rounded-xl bg-white border-2 border-transparent peer-checked:border-[#9F3E28] shadow-sm hover:shadow-md transition-all flex items-center gap-3">
                                <div class="p-2 rounded-full bg-orange-50 text-orange-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                                <span class="font-bold text-gray-700">Rekan Dosen / Staf</span>
                            </div>
                        </label>

                        <label class="cursor-pointer relative group">
                            <input type="radio" name="receiver_role" value="mahasiswa" class="peer sr-only" onclick="toggleOptions('mahasiswa')">
                            <div class="p-4 rounded-xl bg-white border-2 border-transparent peer-checked:border-[#9F3E28] shadow-sm hover:shadow-md transition-all flex items-center gap-3">
                                <div class="p-2 rounded-full bg-blue-50 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                                </div>
                                <span class="font-bold text-gray-700">Mahasiswa</span>
                            </div>
                        </label>
                    </div>

                    <div id="angkatan-container" class="bg-white p-5 rounded-xl border border-blue-100 mt-4 hidden animate-fade-in-down">
                        <label class="block text-gray-700 font-bold mb-2 text-sm">Pilih Tahun Angkatan (Opsional)</label>
                        <select name="angkatan" class="w-full rounded-xl border-gray-200 focus:border-[#9F3E28] focus:ring focus:ring-[#9F3E28]/20 transition py-3 px-4 bg-gray-50 text-gray-700 font-medium">
                            <option value="">-- Kirim ke SEMUA Angkatan --</option>
                            @foreach($angkatans as $thn)
                                <option value="{{ $thn }}">Mahasiswa Angkatan {{ $thn }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-2">*Jika dibiarkan kosong, pesan akan dikirim ke seluruh mahasiswa aktif.</p>
                    </div>

                    <div id="dosen-options" class="bg-white p-4 rounded-xl border border-orange-100 mt-4">
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="broadcast_all" value="1" class="w-5 h-5 rounded text-[#9F3E28] focus:ring-[#9F3E28]" checked>
                            <span class="text-gray-700 font-medium">Kirim Broadcast ke Seluruh Dosen Fakultas</span>
                        </label>
                    </div>

                </div>

                <div>
                    <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wider flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                        </svg>
                        Template Cepat
                    </h3>
                    
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-gray-100 text-[10px] font-bold text-gray-500 rounded uppercase self-center mr-1">Rapat:</span>
                        <button type="button" onclick="fillTemplate('Undangan Rapat Kurikulum', 'Kepada Yth. Bapak/Ibu Dosen,\n\nMohon kehadirannya dalam Rapat Evaluasi Kurikulum...')" 
                            class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold hover:bg-blue-100 transition border border-blue-100">
                            📘 Rapat Kurikulum
                        </button>

                        <div class="w-full md:w-auto md:hidden"></div>
                        <span class="px-2 py-1 bg-gray-100 text-[10px] font-bold text-gray-500 rounded uppercase self-center mr-1 ml-0 md:ml-4">Mhs:</span>
                        <button type="button" onclick="fillTemplate('Informasi Perubahan Jadwal Kuliah', 'Diberitahukan kepada seluruh mahasiswa angkatan [Tahun] bahwa mata kuliah...')" 
                            class="px-3 py-1.5 rounded-lg bg-green-50 text-green-700 text-xs font-bold hover:bg-green-100 transition border border-green-100">
                            📢 Ubah Jadwal
                        </button>
                        <button type="button" onclick="fillTemplate('Pengumpulan Tugas Akhir', 'Deadline pengumpulan Draft Tugas Akhir diperpanjang hingga...')" 
                            class="px-3 py-1.5 rounded-lg bg-green-50 text-green-700 text-xs font-bold hover:bg-green-100 transition border border-green-100">
                            📚 Tugas Akhir
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Perihal / Judul Surat</label>
                        <input type="text" name="subject" id="subject" placeholder="Contoh: Undangan Rapat / Info Kuliah" 
                            class="w-full rounded-xl border-gray-200 focus:border-[#9F3E28] focus:ring focus:ring-[#9F3E28]/20 transition py-3 px-4 bg-white font-medium" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Isi Pengumuman</label>
                        <textarea name="body" id="body" rows="8" placeholder="Isi detail pengumuman di sini..." 
                            class="w-full rounded-xl border-gray-200 focus:border-[#9F3E28] focus:ring focus:ring-[#9F3E28]/20 transition py-3 px-4 bg-white leading-relaxed resize-none" required></textarea>
                    </div>
                </div>

                <hr class="border-gray-100">

                <button type="submit" class="w-full text-white font-bold py-4 px-8 rounded-xl shadow-lg transition transform hover:scale-[1.01] flex items-center justify-center gap-2" style="background-color: #9F3E28;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                    Kirim Pengumuman
                </button>

            </form>
        </div>
    </div>
</div>

<script>
    function fillTemplate(judul, isi) {
        document.getElementById('subject').value = judul;
        document.getElementById('body').value = isi;
    }

    function toggleOptions(role) {
        const angkatanContainer = document.getElementById('angkatan-container');
        const dosenOptions = document.getElementById('dosen-options');

        if (role === 'mahasiswa') {
            // Tampilkan Dropdown Angkatan, Sembunyikan Checkbox Dosen
            angkatanContainer.classList.remove('hidden');
            dosenOptions.classList.add('hidden');
        } else {
            // Tampilkan Checkbox Dosen, Sembunyikan Dropdown Angkatan
            angkatanContainer.classList.add('hidden');
            dosenOptions.classList.remove('hidden');
        }
    }
    
    // Jalankan sekali saat load untuk memastikan state awal benar
    document.addEventListener("DOMContentLoaded", function() {
        // Cek radio mana yang checked
        const checkedRadio = document.querySelector('input[name="receiver_role"]:checked');
        if(checkedRadio) {
            toggleOptions(checkedRadio.value);
        }
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    
    /* Animasi Simpel */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.3s ease-out forwards;
    }
</style>

@endcomponent