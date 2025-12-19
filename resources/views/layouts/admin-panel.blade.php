<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Admin Panel') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Figtree', sans-serif; }
        
        /* TEMA ADMIN (BIRU) */
        .bg-sidebar-theme { background-color: #F0F5FA; } 
        .text-active-theme { color: #1E40AF; } 
        .bg-active-theme { background-color: #2d49a4ff; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans antialiased h-screen flex flex-col overflow-hidden">

    <header class="h-20 shrink-0 flex items-center justify-between px-10 bg-white z-50">
        <div class="flex items-center gap-4">
            <span class="text-xl font-bold tracking-tight text-gray-800">
                Admin <span class="text-black-600">Panel</span>
            </span>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-gray-500 font-medium">Status :</span>
            <div class="flex items-center font-bold text-blue-800 cursor-pointer">
                Administrator
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </header>

    <div class="flex-1 flex overflow-hidden px-8 pb-4 gap-8">
        
        <aside class="w-72 bg-sidebar-theme rounded-[40px] flex flex-col py-8 px-2 shadow-[0_0_0_0px_rgba(0,0,0,0)] h-full overflow-y-auto">
            
            <div class="px-6 mb-4">
                <h3 class="text-gray-800 font-medium text-lg pb-4 border-b-2 border-blue-200/30">
                    Menu Kelola
                </h3>
            </div>

            <nav class="space-y-2 px-2">
                
                <a href="{{ route('dashboard') }}" class="group relative flex items-center px-4 py-3 font-medium transition-all">
                     @if(request()->routeIs('dashboard'))
                        <div class="absolute left-0 h-8 w-1.5 bg-active-theme rounded-r-full"></div>
                    @endif
                    <span class="ml-4 {{ request()->routeIs('dashboard') ? 'text-gray-900 font-bold' : 'text-gray-600 group-hover:text-active-theme' }}">
                        Dashboard
                    </span>
                    @if(request()->routeIs('dashboard')) <span class="ml-2 w-2 h-2 bg-active-theme rounded-full"></span> @endif
                </a>

                <a href="{{ route('mahasiswa.index') }}" class="group relative flex items-center px-4 py-3 font-medium transition-all">
                     @if(request()->routeIs('mahasiswa.*'))
                        <div class="absolute left-0 h-8 w-1.5 bg-active-theme rounded-r-full"></div>
                    @endif
                    <span class="ml-4 {{ request()->routeIs('mahasiswa.*') ? 'text-gray-900 font-bold' : 'text-gray-600 group-hover:text-active-theme' }}">
                        Data Mahasiswa
                    </span>
                    @if(request()->routeIs('mahasiswa.*')) <span class="ml-2 w-2 h-2 bg-active-theme rounded-full"></span> @endif
                </a>

                <a href="{{ route('dosen.index') }}" class="group relative flex items-center px-4 py-3 font-medium transition-all">
                     @if(request()->routeIs('dosen.*'))
                        <div class="absolute left-0 h-8 w-1.5 bg-active-theme rounded-r-full"></div>
                    @endif
                    <span class="ml-4 {{ request()->routeIs('dosen.*') ? 'text-gray-900 font-bold' : 'text-gray-600 group-hover:text-active-theme' }}">
                        Data Dosen
                    </span>
                    @if(request()->routeIs('dosen.*')) <span class="ml-2 w-2 h-2 bg-active-theme rounded-full"></span> @endif
                </a>

                <a href="{{ route('profile.edit') }}" class="group relative flex items-center px-4 py-3 font-medium transition-all">
                     @if(request()->routeIs('profile.*'))
                        <div class="absolute left-0 h-8 w-1.5 bg-active-theme rounded-r-full"></div>
                    @endif
                    <span class="ml-4 {{ request()->routeIs('profile.*') ? 'text-gray-900 font-bold' : 'text-gray-600 group-hover:text-active-theme' }}">
                        Profil
                    </span>
                    @if(request()->routeIs('profile.*')) <span class="ml-2 w-2 h-2 bg-active-theme rounded-full"></span> @endif
                </a>

            </nav>
        </aside>

        <main class="flex-1 bg-white rounded-[40px] shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-gray-100 relative overflow-hidden flex flex-col">
            <div class="flex-1 overflow-y-auto p-8">
                {{ $slot }}
            </div>
        </main>

    </div>

    <footer class="h-20 shrink-0 px-10 flex items-center justify-between bg-white border-t border-transparent">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 text-gray-500 hover:text-blue-600 transition group">
                <div class="p-2 rounded-full group-hover:bg-blue-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <span class="font-medium text-lg">Logout</span>
            </button>
        </form>
        
        <div class="text-right select-none">
             <div class="text-xl font-bold text-gray-400">
                Waktu : <span id="realtime-clock" class="text-gray-500">--.--</span>
             </div>
             <div id="realtime-date" class="text-xs text-gray-300 font-medium tracking-widest mt-1">
                -- / -- / --
             </div>
        </div>
    </footer>

    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = String(now.getFullYear()).slice(-2);
            document.getElementById('realtime-clock').innerText = `${hours}.${minutes}`;
            document.getElementById('realtime-date').innerText = `${day} / ${month} / ${year}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

</body>
</html>