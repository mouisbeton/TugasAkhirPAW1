<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengumuman Fakultas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('messages.store') }}" method="POST" id="messageForm">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Kirim Kepada Siapa?</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-blue-50 transition border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="target_type" value="dosen" checked onclick="toggleTarget('dosen')" class="mr-2 text-blue-600 focus:ring-blue-500">
                                    <span class="font-bold text-gray-700">Rekan Dosen / Staf</span>
                                </label>
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-green-50 transition border-gray-200 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                    <input type="radio" name="target_type" value="mahasiswa" onclick="toggleTarget('mahasiswa')" class="mr-2 text-green-600 focus:ring-green-500">
                                    <span class="font-bold text-gray-700">Mahasiswa Satu Angkatan</span>
                                </label>
                            </div>
                        </div>

                        <div id="dosen-options" class="mb-6 border border-blue-200 p-4 rounded-lg bg-blue-50">
                            <h4 class="font-bold mb-2 text-blue-700">Pilih Rekan Dosen:</h4>
                            
                            <div class="mb-3 pb-2 border-b border-blue-200">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="checkAll" onclick="toggleSelectAll(this)" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                    <span class="ml-2 text-sm font-bold text-gray-700">Pilih Semua Dosen (Broadcast Fakultas)</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2 max-h-48 overflow-y-auto">
                                @foreach($dosen as $d)
                                <label class="inline-flex items-center cursor-pointer hover:bg-blue-100 p-1 rounded">
                                    <input type="checkbox" name="dosen_ids[]" value="{{ $d->id }}" class="dosen-checkbox form-checkbox h-4 w-4 text-blue-600 rounded">
                                    <span class="ml-2 text-sm">{{ $d->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="mahasiswa-options" class="mb-6 border border-green-200 p-4 rounded-lg bg-green-50 hidden">
                            <h4 class="font-bold mb-2 text-green-700">Filter Mahasiswa:</h4>
                            <p class="text-xs text-gray-500 mb-2">*Pengumuman ini bersifat massal per angkatan.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold mb-1 text-gray-700">Pilih Angkatan</label>
                                    <select name="angkatan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="all">-- Kirim ke Seluruh Mahasiswa Aktif --</option>
                                        @foreach($angkatan as $akt)
                                            <option value="{{ $akt }}">Angkatan {{ $akt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-300">

                        <div class="mb-5">
                            <label class="block text-gray-700 font-bold mb-2">⚡ Template Surat/Pengumuman (Klik untuk pakai)</label>
                            
                            <div class="mb-2">
                                <span class="text-xs font-bold text-blue-600 mr-2 uppercase tracking-wide bg-blue-50 px-2 py-1 rounded">Rapat:</span>
                                <button type="button" onclick="isiTemplate('kurikulum')" class="bg-white border border-blue-200 hover:bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">📘 Rapat Kurikulum</button>
                                <button type="button" onclick="isiTemplate('prodi')" class="bg-white border border-blue-200 hover:bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">👥 Rapat Prodi</button>
                                <button type="button" onclick="isiTemplate('pleno')" class="bg-white border border-blue-200 hover:bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">🏛️ Rapat Pleno</button>
                            </div>

                            <div class="mb-2">
                                <span class="text-xs font-bold text-yellow-600 mr-2 uppercase tracking-wide bg-yellow-50 px-2 py-1 rounded">SOP & Ujian:</span>
                                <button type="button" onclick="isiTemplate('sop_ujian')" class="bg-white border border-yellow-200 hover:bg-yellow-50 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">📝 SOP Ujian Akhir</button>
                                <button type="button" onclick="isiTemplate('koordinasi_pengawas')" class="bg-white border border-yellow-200 hover:bg-yellow-50 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">👀 Koordinasi Pengawas</button>
                                <button type="button" onclick="isiTemplate('yudisium')" class="bg-white border border-yellow-200 hover:bg-yellow-50 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">🎓 Info Yudisium</button>
                            </div>

                            <div>
                                <span class="text-xs font-bold text-green-600 mr-2 uppercase tracking-wide bg-green-50 px-2 py-1 rounded">Kegiatan:</span>
                                <button type="button" onclick="isiTemplate('workshop')" class="bg-white border border-green-200 hover:bg-green-50 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">🛠️ Workshop Dosen</button>
                                <button type="button" onclick="isiTemplate('akreditasi')" class="bg-white border border-green-200 hover:bg-green-50 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">🏆 Persiapan Akreditasi</button>
                                <button type="button" onclick="isiTemplate('umum')" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold px-3 py-1 rounded-full mr-1 mb-1 transition shadow-sm">📢 Pengumuman Umum</button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Perihal / Judul Surat</label>
                            <input type="text" id="subjectInput" name="subject" class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition" placeholder="Contoh: Undangan Rapat Evaluasi Semester Ganjil" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Isi Pengumuman</label>
                            <textarea name="content" id="pesanArea" rows="10" class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm font-mono text-sm transition" placeholder="Isi detail pengumuman di sini..." required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                            🚀 Kirim Pengumuman
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleTarget(type) {
            if (type === 'dosen') {
                document.getElementById('dosen-options').classList.remove('hidden');
                document.getElementById('mahasiswa-options').classList.add('hidden');
            } else {
                document.getElementById('dosen-options').classList.add('hidden');
                document.getElementById('mahasiswa-options').classList.remove('hidden');
            }
        }

        function toggleSelectAll(source) {
            checkboxes = document.getElementsByClassName('dosen-checkbox');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        function isiTemplate(jenis) {
            let subject = ""; 
            let content = ""; 

            if(jenis === 'kurikulum') {
                subject = "Undangan Rapat Evaluasi Kurikulum T.A 2024/2025";
                content = "Yth. Bapak/Ibu Dosen,\n\nMengharap kehadiran Bapak/Ibu pada Rapat Evaluasi Kurikulum yang akan dilaksanakan pada:\n\n📅 Hari/Tanggal: [HARI, TANGGAL]\n🕒 Waktu: 09.00 - Selesai\n📍 Tempat: Ruang Rapat Utama Lt. 2\n\nAgenda: Peninjauan RPS dan sebaran mata kuliah.\nMohon hadir tepat waktu. Terima kasih.";
            
            } else if (jenis === 'prodi') {
                subject = "Undangan Rapat Koordinasi Program Studi";
                content = "Kepada Yth. Dosen Program Studi,\n\nKami mengundang Bapak/Ibu untuk menghadiri rapat rutin bulanan prodi guna membahas perkembangan akademik semester berjalan.\n\n📅 Jadwal: [TANGGAL]\n🕒 Jam: [JAM]\n📍 Lokasi: Ruang Sidang Prodi\n\nDemikian undangan ini kami sampaikan.";

            } else if (jenis === 'pleno') {
                subject = "Undangan Rapat Pleno Fakultas";
                content = "Yth. Seluruh Civitas Akademika,\n\nDiberitahukan bahwa akan diadakan Rapat Pleno Awal Semester untuk persiapan perkuliahan.\n\n📅 Tanggal: [TANGGAL]\n📍 Tempat: Auditorium Kampus\n👔 Pakaian: Batik/Formal\n\nKehadiran bersifat wajib bagi seluruh dosen tetap. Terima kasih.";

            } else if (jenis === 'sop_ujian') {
                subject = "Sosialisasi SOP Pelaksanaan Ujian Akhir Semester (UAS)";
                content = "Yth. Bapak/Ibu Dosen Pengampu Mata Kuliah,\n\nBerikut kami sampaikan Standar Operasional Prosedur (SOP) terkait pelaksanaan UAS Semester ini:\n\n1. Soal wajib disubmit ke BAAK maksimal H-3 ujian.\n2. Pengawas wajib hadir 15 menit sebelum ujian dimulai.\n3. Berita acara ujian wajib diisi lengkap.\n\nMohon dijadikan pedoman agar pelaksanaan ujian berjalan tertib.";

            } else if (jenis === 'koordinasi_pengawas') {
                subject = "Jadwal Koordinasi Pengawas Ujian";
                content = "PEMBERITAHUAN PENTING\n\nKepada seluruh Dosen yang bertugas sebagai Pengawas Ujian, dimohon hadir pada briefing teknis pengawasan:\n\n📅 Hari: [HARI]\n🕒 Pukul: [JAM]\n📍 Tempat: Ruang Dosen\n\nAgenda: Pembagian jadwal jaga dan pengambilan berkas ujian.";

            } else if (jenis === 'yudisium') {
                subject = "Pengumuman Pendaftaran Yudisium Periode Ini";
                content = "Diberitahukan kepada Mahasiswa Tingkat Akhir,\n\nPendaftaran Yudisium Periode [BULAN] telah dibuka. Syarat dan ketentuan:\n\n1. Bebas tanggungan perpustakaan & keuangan.\n2. Telah menyelesaikan revisi skripsi.\n3. Submit jurnal.\n\nBatas akhir pendaftaran: [TANGGAL]. Harap diperhatikan.";

            } else if (jenis === 'workshop') {
                subject = "Undangan Workshop Peningkatan Kompetensi Dosen";
                content = "Yth. Rekan Dosen,\n\nFakultas akan menyelenggarakan Workshop dengan tema 'Pemanfaatan AI dalam Pembelajaran'.\n\n🗣️ Narasumber: [NAMA AHLI]\n📅 Waktu: [TANGGAL]\n📍 Tempat: Lab Komputer 1\n\nSertifikat tersedia. Mohon konfirmasi kehadiran melalui sekretariat.";

            } else if (jenis === 'akreditasi') {
                subject = "Persiapan Visitasi Akreditasi Program Studi";
                content = "MOHON PERHATIAN,\n\nSehubungan dengan jadwal visitasi Asesor BAN-PT yang akan dilaksanakan minggu depan, dimohon seluruh dosen melengkapi berkas portofolio pengajaran dan penelitian paling lambat hari Jumat ini.\n\nKerja sama Bapak/Ibu sangat menentukan hasil akreditasi kita. Terima kasih.";
            
            } else if (jenis === 'umum') {
                subject = "Pemberitahuan Umum Fakultas";
                content = "Assalamu’alaikum Wr. Wb.\n\nBerikut kami sampaikan informasi terkait libur akademik dan jam operasional layanan fakultas selama bulan Ramadhan:\n\n1. Jam Layanan: 08.00 - 15.00 WIB\n2. Libur Awal Puasa: [TANGGAL]\n\nDemikian untuk diketahui bersama.";
            }

            document.getElementById('subjectInput').value = subject;
            document.getElementById('pesanArea').value = content;
        }
    </script>
</x-app-layout>