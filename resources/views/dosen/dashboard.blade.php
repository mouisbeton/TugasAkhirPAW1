@component('layouts.dosen-panel')

    <div class="h-full flex flex-col gap-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between p-2">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Selamat datang, <span style="color: #000000ff;">{{ Auth::user()->name }}</span>.
                </h1>
                <p class="text-gray-500 mt-2 text-lg font-medium">
                    Ringkasan aktivitas akademik saat ini.
                </p>
            </div>
            
            <div class="mt-4 md:mt-0 text-right">
                <span class="text-sm font-bold uppercase tracking-widest" style="color: #9F3E28;">
                    Semester Ganjil
                </span>
                <div class="text-gray-400 text-sm">2025/2026</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <a href="#" class="group bg-white p-8 rounded-[35px] border border-gray-100/50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(159,62,40,0.1)] transition-all duration-300 flex flex-col justify-between h-64">
                <div>
                    <div class="mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #9F3E28;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-[#9F3E28] transition">Buat Pesan Baru</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Kirim pengumuman atau tugas kepada mahasiswa.
                    </p>
                </div>

                <div class="flex items-center text-sm font-bold mt-4" style="color: #9F3E28;">
                    Tulis Sekarang 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-2 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            </a>

            <a href="#" class="group bg-white p-8 rounded-[35px] border border-gray-100/50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(159,62,40,0.1)] transition-all duration-300 flex flex-col justify-between h-64">
                <div>
                    <div class="mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #9F3E28;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-[#9F3E28] transition">Kotak Masuk</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Cek pesan dan notifikasi terbaru Anda.
                    </p>
                </div>

                <div class="flex items-center text-sm font-bold mt-4" style="color: #9F3E28;">
                    Lihat Inbox
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-2 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            </a>

        </div>

        <div class="bg-white rounded-[30px] border border-gray-100/50 shadow-sm p-8 flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-gray-100">
            
            <div class="flex-1 flex items-center gap-4 p-4">
                <div class="text-3xl font-extrabold text-gray-800">12</div>
                <div class="text-sm text-gray-400 font-medium uppercase tracking-wider leading-tight">
                    Pesan <br> Terkirim
                </div>
            </div>

            <div class="flex-1 flex items-center gap-4 p-4">
                <div class="text-3xl font-extrabold text-gray-800">3</div>
                <div class="text-sm text-gray-400 font-medium uppercase tracking-wider leading-tight">
                    Menunggu <br> Respon
                </div>
            </div>

             <div class="flex-1 flex items-center gap-4 p-4">
                <div class="text-3xl font-extrabold text-gray-800">
                     {{ \App\Models\User::where('role', 'mahasiswa')->count() }}
                </div>
                <div class="text-sm text-gray-400 font-medium uppercase tracking-wider leading-tight">
                    Total <br> Mahasiswa
                </div>
            </div>

        </div>

    </div>

@endcomponent