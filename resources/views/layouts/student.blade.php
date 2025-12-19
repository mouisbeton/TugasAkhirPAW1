<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        /* Kustomisasi scrollbar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; rounded: 10px; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F4F7FC]">
    
    <div class="flex h-screen overflow-hidden">

        <div class="w-64 bg-[#EBF1F6] flex flex-col justify-between p-6">
            <div>
                <div class="mb-8">
                    <h1 class="font-bold text-xl text-gray-800">SISTEM AKADEMIK</h1>
                </div>

                <div class="flex items-center mb-10">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=FF6B6B&color=fff" alt="Avatar" class="w-10 h-10 rounded-full mr-3 border-2 border-white shadow-sm">
                    <div>
                        <h3 class="font-bold text-sm text-gray-800">{{ Auth::user()->name }}</h3>
                        <p class="text-xs text-gray-500">Mahasiswa</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl transition-colors {{ request()->routeIs('student.dashboard') ? 'bg-blue-100 text-blue-600 font-bold' : 'hover:bg-white hover:text-blue-600' }}">
                        <i data-feather="grid" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 rounded-xl transition-colors {{ request()->is('student/chat*') ? 'bg-blue-100 text-blue-600 font-bold' : 'hover:bg-white hover:text-blue-600' }}">
                        <i data-feather="message-square" class="w-5 h-5 mr-3"></i>
                        Chat
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 rounded-xl transition-colors hover:bg-white hover:text-blue-600">
                        <i data-feather="activity" class="w-5 h-5 mr-3"></i>
                        My Status
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 rounded-xl transition-colors hover:bg-white hover:text-blue-600">
                        <i data-feather="book-open" class="w-5 h-5 mr-3"></i>
                        My Course
                    </a>
                </nav>
            </div>

            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-3 text-gray-600 rounded-xl transition-colors hover:bg-white hover:text-red-600 w-full">
                        <i data-feather="log-out" class="w-5 h-5 mr-3"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>


        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="bg-white p-4 flex justify-between items-center border-b border-gray-100">
                <div class="flex items-center bg-gray-100 rounded-lg px-4 py-2 w-1/3">
                    <i data-feather="search" class="w-4 h-4 text-gray-400 mr-2"></i>
                    <input type="text" placeholder="Search" class="bg-transparent border-none focus:ring-0 text-sm w-full">
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-400 hover:text-gray-600"><i data-feather="bell" class="w-5 h-5"></i></button>
                    <button class="text-gray-400 hover:text-gray-600"><i data-feather="message-circle" class="w-5 h-5"></i></button>
                </div>
            </header>

            <div class="flex-1 flex overflow-hidden">
                
                <main class="flex-1 overflow-y-auto p-6 bg-[#F4F7FC]">
                    {{ $slot }}
                </main>


                <aside class="w-80 bg-white border-l border-gray-100 overflow-y-auto p-6 hidden xl:block">
                    
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-bold text-gray-700">February 2021</h4>
                            <div class="flex space-x-2">
                                <button class="text-gray-400 hover:text-blue-600"><i data-feather="chevron-left" class="w-4 h-4"></i></button>
                                <button class="text-gray-400 hover:text-blue-600"><i data-feather="chevron-right" class="w-4 h-4"></i></button>
                            </div>
                        </div>
                        <div class="grid grid-cols-7 gap-2 text-center text-sm text-gray-600">
                            <div class="font-bold text-xs text-gray-400">Mo</div><div class="font-bold text-xs text-gray-400">Tu</div><div class="font-bold text-xs text-gray-400">We</div><div class="font-bold text-xs text-gray-400">Th</div><div class="font-bold text-xs text-gray-400">Fr</div><div class="font-bold text-xs text-gray-400 text-blue-500">Sa</div><div class="font-bold text-xs text-gray-400 text-blue-500">Su</div>
                            
                            <div class="py-1 text-gray-300">1</div><div class="py-1 text-gray-300">2</div><div class="py-1 text-gray-300">3</div><div class="py-1 text-gray-300">4</div><div class="py-1">5</div><div class="py-1">6</div><div class="py-1">7</div>
                            <div class="py-1">8</div><div class="py-1">9</div><div class="py-1">10</div><div class="py-1">11</div><div class="py-1">12</div><div class="py-1">13</div><div class="py-1">14</div>
                            <div class="py-1">15</div><div class="py-1">16</div><div class="py-1">17</div><div class="py-1">18</div><div class="py-1 bg-blue-500 text-white rounded-full shadow-sm">19</div><div class="py-1">20</div><div class="py-1">21</div>
                            <div class="py-1">22</div><div class="py-1">23</div><div class="py-1">24</div><div class="py-1">25</div><div class="py-1">26</div><div class="py-1">27</div><div class="py-1">28</div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-700 mb-4">Kegiatan Mendatang</h4>
                        <div class="space-y-4">
                            <div class="bg-[#EBF1F6] p-4 rounded-xl relative overflow-hidden">
                                <div class="absolute top-2 right-2"><i data-feather="more-horizontal" class="w-4 h-4 text-gray-400"></i></div>
                                <h5 class="font-bold text-gray-800">Typography in UX/UI</h5>
                                <div class="flex items-center text-xs text-gray-500 mt-2 space-x-3">
                                    <span class="flex items-center"><i data-feather="layers" class="w-3 h-3 mr-1"></i> Design</span>
                                    <span class="flex items-center"><i data-feather="clock" class="w-3 h-3 mr-1"></i> 10:00 am</span>
                                </div>
                            </div>
                            <div class="bg-[#EBF1F6] p-4 rounded-xl relative overflow-hidden">
                                <div class="absolute top-2 right-2"><i data-feather="more-horizontal" class="w-4 h-4 text-gray-400"></i></div>
                                <h5 class="font-bold text-gray-800">Figma UI UX Design</h5>
                                <div class="flex items-center text-xs text-gray-500 mt-2 space-x-3">
                                    <span class="flex items-center"><i data-feather="layers" class="w-3 h-3 mr-1"></i> Design</span>
                                    <span class="flex items-center"><i data-feather="clock" class="w-3 h-3 mr-1"></i> 10:00 am</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </aside>
            </div>
        </div>
    </div>

    <script>
      feather.replace()
    </script>
</body>
</html>