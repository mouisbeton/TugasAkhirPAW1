<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Akademik') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .bg-sidebar-pink { background-color: #FFF1F1; } 
        .text-active-red { color: #E05D5D; }
        .bg-active-red { background-color: #E05D5D; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    </style>
</head>

@php
    $unreadCount = 0;
    if(Auth::check()){
        // Hitung pesan milik user yg login DAN statusnya 'Berlangsung'
        $unreadCount = \App\Models\Message::where('receiver_id', Auth::id())
                        ->where('status', 'Berlangsung') 
                        ->count();
    }
@endphp

<body class="bg-white text-gray-800 font-sans antialiased h-screen flex flex-col overflow-hidden">

    <header class="h-20 shrink-0 flex items-center justify-between px-10 bg-white z-50">
        <div class="flex items-center gap-4">
            <div class="text-gray-800"> 
                <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor">
                    <path d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.775C305.52 80.475 305.35 80.195 305.15 79.945C304.88 79.615 304.57 79.325 304.22 79.085C303.95 78.905 303.66 78.755 303.36 78.635L258.66 60.675V11.235C258.66 6.305 255.43 2.085 250.78 0.705C249.27 0.255 247.69 0.015 246.06 0.015C238.44 0.015 231.78 4.415 228.66 11.055L200.15 71.935L155.45 53.975V11.235C155.45 6.305 152.22 2.085 147.57 0.705C146.06 0.255 144.48 0.015 142.85 0.015C135.23 0.015 128.57 4.415 125.45 11.055L96.94 71.935L52.24 53.975V11.235C52.24 6.305 49.01 2.085 44.36 0.705C42.85 0.255 41.27 0.015 39.64 0.015C32.02 0.015 25.36 4.415 22.24 11.055L14.07 28.505C13.88 28.905 13.72 29.325 13.59 29.745C13.56 29.835 13.53 29.935 13.5 30.025C13.14 31.255 13.13 32.555 13.53 33.795L44.17 128.245L9.61 142.135C5.07 143.965 1.76 148.065 1.09 152.935C1.04 153.285 1.01 153.645 1.01 154.005C1.01 159.955 5.09 164.955 10.63 166.575L150.82 207.275L236.46 313.205C238.27 315.445 241.02 316.745 243.9 316.745C243.95 316.745 244 316.745 244.05 316.745C247.01 316.695 249.79 315.315 251.58 312.985L313.73 231.785C315.36 229.665 316.09 226.975 315.73 224.315C315.37 221.655 313.95 219.265 311.83 217.635L267.13 183.195L303.36 78.635C303.66 78.755 303.95 78.905 304.22 79.085C304.57 79.325 304.88 79.615 305.15 79.945C305.35 80.195 305.52 80.475 305.65 80.775C305.69 80.885 305.77 80.995 305.8 81.125V81.125Z"/>
                </svg>
            </div>
            <span class="text-xl font-medium tracking-tight text-gray-800">Sistem Kelola</span>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-gray-500 font-medium">Status :</span>
            <div class="flex items-center font-bold text-gray-700 cursor-pointer">
                Mahasiswa
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </header>

    <div class="flex-1 flex overflow-hidden px-8 pb-4 gap-8">
        
        <aside class="w-72 bg-sidebar-pink rounded-[40px] flex flex-col py-8 px-2 shadow-[0_0_0_0px_rgba(0,0,0,0)] h-full overflow-y-auto">
            
            <div class="px-6 mb-4">
                <h3 class="text-gray-800 font-medium text-lg pb-4 border-b-2 border-red-200/30">
                    Menu Kelola Akademik
                </h3>
            </div>

            <nav class="space-y-2 px-2">
                
                <a href="{{ route('messages.index') }}" class="group relative flex items-center justify-between px-4 py-3 font-medium transition-all">
                     @if(request()->routeIs('messages.*'))
                        <div class="absolute left-0 h-8 w-1.5 bg-active-red rounded-r-full"></div>
                    @endif

                    <div class="flex items-center ml-4">
                        <span class="{{ request()->routeIs('messages.*') ? 'text-gray-800 font-bold' : 'text-gray-600 group-hover:text-red-500' }}">
                            Kotak Masuk
                        </span>
                        @if(request()->routeIs('messages.*'))
                            <span class="ml-2 w-2 h-2 bg-active-red rounded-full"></span>
                        @endif
                    </div>
                    
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="bg-active-red text-white text-[10px] font-bold h-6 w-6 flex items-center justify-center rounded-full shadow-md">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('kalender') }}" class="group relative flex items-center px-4 py-3 font-medium transition-all">
                     @if(request()->routeIs('kalender'))
                        <div class="absolute left-0 h-8 w-1.5 bg-active-red rounded-r-full"></div>
                    @endif

                    <span class="ml-4 {{ request()->routeIs('kalender') ? 'text-gray-800 font-bold' : 'text-gray-600 group-hover:text-red-500' }}">
                        Kalender
                    </span>

                    @if(request()->routeIs('kalender'))
                        <span class="ml-2 w-2 h-2 bg-active-red rounded-full"></span>
                    @endif
                </a>

                <a href="{{ route('profile.edit') }}" class="group relative flex items-center px-4 py-3 font-medium transition-all">
                     @if(request()->routeIs('profile.*'))
                        <div class="absolute left-0 h-8 w-1.5 bg-active-red rounded-r-full"></div>
                    @endif

                    <span class="ml-4 {{ request()->routeIs('profile.*') ? 'text-gray-800 font-bold' : 'text-gray-600 group-hover:text-red-500' }}">
                        Profil
                    </span>

                    @if(request()->routeIs('profile.*'))
                        <span class="ml-2 w-2 h-2 bg-active-red rounded-full"></span>
                    @endif
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
            <button type="submit" class="flex items-center gap-3 text-gray-500 hover:text-red-500 transition group">
                <div class="p-2 rounded-full group-hover:bg-red-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <span class="font-medium text-lg">Logout</span>
            </button>
        </form>

        <div class="text-right" 
             x-data="{ 
                time: '', 
                date: '',
                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },
                updateTime() {
                    const now = new Date();
                    this.time = String(now.getHours()).padStart(2, '0') + '.' + String(now.getMinutes()).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const year = String(now.getFullYear()).slice(-2);
                    this.date = `${day} / ${month} / ${year}`;
                }
             }">
            <div class="text-gray-400 font-medium text-xl">Waktu : <span x-text="time"></span></div>
            <div class="text-gray-300 font-medium text-sm tracking-widest" x-text="date"></div>
        </div>
    </footer>

</body>
</html>