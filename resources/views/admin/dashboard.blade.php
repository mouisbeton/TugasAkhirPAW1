@component('layouts.admin-panel')

    <div class="h-full flex flex-col gap-6">
        
        <div class="flex items-center justify-between bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data akademik sekarang</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Hallo, <span class="text-blue-600 font-bold">{{ Auth::user()->name }}</span>
                </p>
            </div>
            
            <div class="hidden md:flex items-center gap-2">
                <span class="px-4 py-2 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg border border-blue-100">
                    Mode Administrator
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition cursor-default">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Mahasiswa</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\User::where('role', 'mahasiswa')->count() }}
                    </h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition cursor-default">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Dosen</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\User::where('role', 'dosen')->count() }}
                    </h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition cursor-default">
                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Akun</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\User::count() }}
                    </h3>
                </div>
            </div>

        </div>

        <div class="flex-1">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 ml-1">Akses Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <a href="{{ route('mahasiswa.index') }}" class="group bg-white hover:bg-blue-600 border border-gray-100 rounded-[20px] p-5 transition-all duration-200 flex items-center justify-between shadow-sm hover:shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-white/20 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-gray-800 group-hover:text-white transition">Data Mahasiswa</h4>
                            <p class="text-xs text-gray-400 group-hover:text-blue-100 transition">Kelola data mahasiswa</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('dosen.index') }}" class="group bg-white hover:bg-indigo-600 border border-gray-100 rounded-[20px] p-5 transition-all duration-200 flex items-center justify-between shadow-sm hover:shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-white/20 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-gray-800 group-hover:text-white transition">Data Dosen</h4>
                            <p class="text-xs text-gray-400 group-hover:text-indigo-100 transition">Kelola data dosen</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

            </div>
        </div>

    </div>

@endcomponent