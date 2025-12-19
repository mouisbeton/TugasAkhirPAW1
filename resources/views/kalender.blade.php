@component('layouts.student-panel')

    <div x-data="{
        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        selectedDate: new Date(),
        
        events: {{ \Illuminate\Support\Js::from($events) }},

        get currentMonthName() { return this.monthNames[this.currentMonth]; },

        get blankDays() {
            const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1).getDay();
            return Array.from({ length: firstDayOfMonth });
        },

        get monthDays() {
            const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            return Array.from({ length: daysInMonth }, (_, i) => i + 1);
        },

        changeMonth(step) {
            this.currentMonth += step;
            if (this.currentMonth < 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else if (this.currentMonth > 11) {
                this.currentMonth = 0;
                this.currentYear++;
            }
        },

        selectDate(day) {
            this.selectedDate = new Date(this.currentYear, this.currentMonth, day);
        },

        isSelected(day) {
            return this.selectedDate.getDate() === day &&
                   this.selectedDate.getMonth() === this.currentMonth &&
                   this.selectedDate.getFullYear() === this.currentYear;
        },

        isToday(day) {
            const today = new Date();
            return today.getDate() === day &&
                   today.getMonth() === this.currentMonth &&
                   today.getFullYear() === this.currentYear;
        },

        hasEvent(day) {
            const checkDate = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            return this.events.some(e => e.date === checkDate);
        },

        isEventFinished(day) {
            const checkDate = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const event = this.events.find(e => e.date === checkDate);
            return event && event.status === 'Selesai';
        },

        getEventsForSelectedDate() {
            const day = this.selectedDate.getDate();
            const month = this.selectedDate.getMonth();
            const year = this.selectedDate.getFullYear();
            const checkDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            return this.events.filter(e => e.date === checkDate);
        }

    }" class="h-full flex flex-col">
        
        <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-8 flex gap-8 h-full">
            
            <div class="flex-1 flex flex-col">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold text-gray-700" x-text="`${currentMonthName} ${currentYear}`"></h3>
                    <div class="flex gap-3">
                        <button @click="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button @click="changeMonth(1)" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-7 mb-4">
                    <template x-for="day in daysOfWeek">
                        <div class="text-center text-xs font-semibold text-gray-400 uppercase tracking-wider" x-text="day"></div>
                    </template>
                </div>

                <div class="grid grid-cols-7 gap-y-4 gap-x-2 flex-1 content-start">
                    <template x-for="blank in blankDays">
                        <div class="h-10"></div>
                    </template>

                    <template x-for="day in monthDays">
                        <div class="flex justify-center">
                            <button @click="selectDate(day)"
                                 class="w-10 h-10 flex items-center justify-center rounded-full text-sm transition relative"
                                 :class="{
                                    // 1. KLIK + SELESAI = Biru Tua (Solid)
                                    'bg-blue-500 text-white shadow-md shadow-blue-200': isSelected(day) && hasEvent(day) && isEventFinished(day),

                                    // 2. KLIK + BERLANGSUNG = Merah Tua (Solid)
                                    'bg-red-500 text-white shadow-md shadow-red-200': isSelected(day) && !(hasEvent(day) && isEventFinished(day)),
                                    
                                    // 3. TIDAK KLIK + SELESAI = Biru Soft
                                    'bg-blue-100 text-blue-600 font-bold': !isSelected(day) && hasEvent(day) && isEventFinished(day),

                                    // 4. TIDAK KLIK + BERLANGSUNG = Merah Soft
                                    'bg-red-100 text-red-500 font-bold': !isSelected(day) && hasEvent(day) && !isEventFinished(day),
                                    
                                    // 5. KOSONG
                                    'text-gray-600 hover:bg-gray-50': !isSelected(day) && !hasEvent(day),
                                    'border border-red-300': isToday(day) && !isSelected(day) && !hasEvent(day)
                                 }">
                                <span x-text="day"></span>
                                
                                <div x-show="hasEvent(day)" 
                                     class="absolute -bottom-1 w-1 h-1 rounded-full"
                                     :class="{
                                         'bg-white': isSelected(day),
                                         'bg-blue-400': !isSelected(day) && isEventFinished(day),
                                         'bg-red-400': !isSelected(day) && !isEventFinished(day)
                                     }">
                                </div>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <div class="w-px bg-gray-100 my-4 hidden md:block"></div>

            <div class="w-[300px] hidden md:block relative">
                <div class="bg-blue-50/50 h-full rounded-3xl p-5 overflow-hidden relative border border-blue-100">
                    <div class="flex justify-between text-[10px] text-gray-400 font-bold mb-4 px-1 border-b border-blue-200 pb-2 uppercase tracking-wide">
                        <span>Tanggal</span>
                        <span>Info</span>
                    </div>

                    <div class="space-y-3">
                         <template x-for="event in getEventsForSelectedDate()">
                            <div class="bg-white p-3 rounded-xl border border-blue-100 shadow-sm flex flex-col gap-1 cursor-pointer hover:shadow-md transition">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-gray-700" x-text="event.title"></span>
                                </div>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-[10px] text-gray-400" x-text="event.type"></span>
                                    
                                    <template x-if="event.status === 'Selesai'">
                                        <span class="bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-[8px] font-bold">Selesai</span>
                                    </template>

                                    <template x-if="event.status !== 'Selesai'">
                                        <span class="bg-green-100 text-green-600 px-2 py-0.5 rounded text-[8px] font-bold">Aktif</span>
                                    </template>

                                </div>
                            </div>
                        </template>

                        <div x-show="getEventsForSelectedDate().length === 0" class="text-center mt-20 opacity-60">
                            <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-xs text-gray-500">Tidak ada jadwal</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endcomponent