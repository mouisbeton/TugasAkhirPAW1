import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// --- TAMBAHKAN BAGIAN INI (Logika Kalender) ---
document.addEventListener('alpine:init', () => {
    Alpine.data('kalenderApp', () => ({
        currDate: new Date(),
        selectedDate: new Date(),
        events: [
            { date: 15, title: "Kumpul Tugas", type: "tugas" },
            { date: 20, title: "UAS Algoritma", type: "ujian" }
        ],
        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],

        get currentMonthName() {
            return this.monthNames[this.currDate.getMonth()];
        },
        get currentYear() {
            return this.currDate.getFullYear();
        },
        get daysInMonth() {
            return new Date(this.currDate.getFullYear(), this.currDate.getMonth() + 1, 0).getDate();
        },
        get firstDayOfMonth() {
            return new Date(this.currDate.getFullYear(), this.currDate.getMonth(), 1).getDay();
        },
        // Array kosong untuk padding hari sebelum tanggal 1
        get blankDays() {
            return Array.from({ length: this.firstDayOfMonth });
        },
        // Array tanggal 1 sampai akhir bulan
        get monthDays() {
            return Array.from({ length: this.daysInMonth }, (_, i) => i + 1);
        },
        
        changeMonth(offset) {
            this.currDate = new Date(this.currDate.getFullYear(), this.currDate.getMonth() + offset, 1);
        },
        selectDate(day) {
            this.selectedDate = new Date(this.currDate.getFullYear(), this.currDate.getMonth(), day);
        },
        isToday(day) {
            const today = new Date();
            return day === today.getDate() && 
                   this.currDate.getMonth() === today.getMonth() && 
                   this.currDate.getFullYear() === today.getFullYear();
        },
        isSelected(day) {
            return day === this.selectedDate.getDate() && 
                   this.currDate.getMonth() === this.selectedDate.getMonth();
        },
        hasEvent(day) {
            return this.events.find(e => e.date === day);
        },
        getSelectedEvents() {
            return this.events.filter(e => e.date === this.selectedDate.getDate());
        }
    }))
});
// ----------------------------------------------

Alpine.start();