<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Akademik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 text-gray-800 font-sans antialiased">

    <div x-data="{ activeMenu: 'kalender' }" class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-white shadow-xl z-10 flex flex-col">
            <div class="p-6">
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">
                    Sistem <span class="text-red-500">Akademik</span>
                </h1>
                <p class="text-xs text-gray-400 mt-1">Tugas Akhir PAW</p>
            </div>

            <nav class="mt-6 flex-1 px-4 space-y-2">
                <a href="#" 
                   @click.prevent="activeMenu = 'dashboard'"
                   :class="activeMenu === 'dashboard' ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50'"
                   class="flex items-center px-4 py-3 rounded-xl transition-all group">
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="#" 
                   @click.prevent="activeMenu = 'kotak_masuk'"
                   :class="activeMenu === 'kotak_masuk' ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50'"
                   class="flex items-center justify-between px-4 py-3 rounded-xl transition-all">
                    <span class="font-medium">Kotak Masuk</span>
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">4</span>
                </a>

                <a href="#" 
                   @click.prevent="activeMenu = 'kalender'"
                   :class="activeMenu === 'kalender' ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50'"
                   class="flex items-center px-4 py-3 rounded-xl transition-all">
                    <span class="font-medium">Kalender</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <a href="{{ route('login') }}" class="flex items-center text-gray-500 hover:text-red-500 transition px-4 py-2 text-sm font-medium">
                    ← Kembali ke Login
                </a>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-pink-50/50 p-8">
            
            <div x-show="activeMenu === 'dashboard'" x-transition>
                <h2 class="text-3xl font-bold mb-4">Dashboard</h2>
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <p>Selamat datang di halaman utama.</p>
                </div>
            </div>

            <div x-show="activeMenu === 'kotak_masuk'" x-transition>
                <h2 class="text-3xl font-bold mb-4">Kotak Masuk</h2>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100">
                    <p class="text-gray-600">Anda memiliki 4 pesan belum dibaca.</p>
                </div>
            </div>

            <div x-show="activeMenu === 'kalender'" 
                 x-data="kalenderApp" 
                 x-transition
                 class="h-full flex flex-col md:flex-row gap-6">
                
                <div class="flex-1 bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800" x-text="currentMonthName + ' ' + currentYear"></h2>
                            <p class="text-sm text-gray-400">Kelola kegiatan akademikmu</p>
                        </div>
                        <div class="flex gap-2">
                            <button @click="changeMonth(-1)" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition text-gray-600">←</button>
                            <button @click="changeMonth(1)" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition text-gray-600">→</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 mb-4">
                        <template x-for="day in daysOfWeek">
                            <div class="text-center text-xs font-bold text-gray-400 uppercase tracking-wider" x-text="day"></div>
                        </template>
                    </div>

                    <div class="grid grid-cols-7 gap-2 md:gap-4">
                        <template x-for="blank in blankDays">
                            <div class="h-14 md:h-24"></div>
                        </template>

                        <template x-for="day in monthDays">
                            <div @click="selectDate(day)"
                                 class="relative h-14 md:h-24 rounded-2xl border transition cursor-pointer flex flex-col items-start justify-start p-2"
                                 :class="{
                                    'bg-red-500 text-white shadow-lg shadow-red-200 border-red-500': isSelected(day),
                                    'border-red-500 bg-white text-gray-800': isToday(day) && !isSelected(day),
                                    'border-gray-100 bg-white hover:border-red-200 hover:bg-red-50/30 text-gray-600': !isSelected(day) && !isToday(day)
                                 }">
                                <span class="font-bold text-sm" x-text="day"></span>
                                
                                <div x-show="hasEvent(day)" class="mt-auto self-center mb-1">
                                    <span class="w-2 h-2 rounded-full block" :class="isSelected(day) ? 'bg-white' : 'bg-red-400'"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="w-full md:w-96 bg-white rounded-3xl shadow-sm border border-gray-100 p-8 flex flex-col">
                    <div class="mb-8">
                        <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider mb-1">Jadwal Terpilih</h3>
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-extrabold text-gray-800" x-text="selectedDate.getDate()"></span>
                            <span class="text-xl font-medium text-red-500" x-text="monthNames[selectedDate.getMonth()]"></span>
                        </div>
                        <div class="text-gray-400 font-medium" x-text="daysOfWeek[selectedDate.getDay()]"></div>
                    </div>

                    <div class="flex-1 overflow-y-auto space-y-4 pr-2">
                        <template x-for="event in getSelectedEvents()">
                            <div class="p-4 rounded-2xl bg-pink-50 border border-pink-100 relative group hover:bg-pink-100 transition">
                                <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-red-500"></div>
                                <h4 class="font-bold text-gray-800 mb-1" x-text="event.title"></h4>
                                <span class="inline-block px-2 py-1 rounded-md bg-white text-xs font-bold text-red-500 uppercase tracking-wide border border-pink-100" x-text="event.type"></span>
                            </div>
                        </template>

                        <div x-show="getSelectedEvents().length === 0" class="text-center py-10">
                            <div class="text-4xl mb-4">☕</div>
                            <p class="text-gray-500 font-medium">Tidak ada kegiatan.</p>
                            <p class="text-gray-400 text-sm">Nikmati hari liburmu!</p>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>