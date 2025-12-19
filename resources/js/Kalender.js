import React, { useState } from 'react';

const Kalender = () => {
  const [currentDate, setCurrentDate] = useState(new Date());
  const [selectedDate, setSelectedDate] = useState(new Date());

  // Data Dummy untuk simulasi Jadwal Akademik
  const events = [
    { date: 15, title: "Pengumpulan Tugas Besar", type: "tugas" },
    { date: 20, title: "UAS Algoritma", type: "ujian" },
    { date: 22, title: "UAS Basis Data", type: "ujian" },
  ];

  // Helper: Nama Hari & Bulan (Indonesia)
  const daysOfWeek = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
  const months = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];

  // Logic: Hitung jumlah hari & hari pertama
  const getDaysInMonth = (date) => {
    return new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
  };

  const getFirstDayOfMonth = (date) => {
    return new Date(date.getFullYear(), date.getMonth(), 1).getDay();
  };

  const changeMonth = (offset) => {
    const newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + offset, 1);
    setCurrentDate(newDate);
  };

  // Render Grid Tanggal
  const renderCalendarDays = () => {
    const totalDays = getDaysInMonth(currentDate);
    const startDay = getFirstDayOfMonth(currentDate);
    const daysArray = [];

    // Kotak kosong sebelum tanggal 1
    for (let i = 0; i < startDay; i++) {
      daysArray.push(<div key={`empty-${i}`} className="h-14"></div>);
    }

    // Kotak Tanggal 1 s.d Akhir
    for (let day = 1; day <= totalDays; day++) {
      const isToday = 
        day === new Date().getDate() && 
        currentDate.getMonth() === new Date().getMonth() &&
        currentDate.getFullYear() === new Date().getFullYear();
      
      const isSelected = 
        day === selectedDate.getDate() &&
        currentDate.getMonth() === selectedDate.getMonth();

      const hasEvent = events.find(e => e.date === day);

      daysArray.push(
        <div 
          key={day}
          onClick={() => setSelectedDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), day))}
          className={`
            h-14 border border-gray-100 flex flex-col items-center justify-center rounded-lg cursor-pointer transition-all relative
            ${isSelected ? 'bg-red-500 text-white shadow-md transform scale-105' : 'hover:bg-pink-50 text-gray-700'}
            ${isToday && !isSelected ? 'border-red-500 border-2' : ''}
          `}
        >
          <span className="font-semibold text-sm">{day}</span>
          
          {/* Titik penanda kalau ada event */}
          {hasEvent && (
            <span className={`w-2 h-2 rounded-full mt-1 ${isSelected ? 'bg-white' : 'bg-red-400'}`}></span>
          )}
        </div>
      );
    }
    return daysArray;
  };

  return (
    <div className="flex gap-6 h-full">
      {/* BAGIAN KIRI: KALENDER UTAMA */}
      <div className="flex-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        
        {/* Header Kalender */}
        <div className="flex justify-between items-center mb-6">
          <h2 className="text-2xl font-bold text-gray-800">
            {months[currentDate.getMonth()]} {currentDate.getFullYear()}
          </h2>
          <div className="flex gap-2">
            <button onClick={() => changeMonth(-1)} className="p-2 hover:bg-gray-100 rounded-full text-gray-600">
              ←
            </button>
            <button onClick={() => changeMonth(1)} className="p-2 hover:bg-gray-100 rounded-full text-gray-600">
              →
            </button>
          </div>
        </div>

        {/* Nama Hari */}
        <div className="grid grid-cols-7 text-center mb-2">
          {daysOfWeek.map(day => (
            <div key={day} className="text-xs font-bold text-gray-400 uppercase tracking-wider py-2">
              {day}
            </div>
          ))}
        </div>

        {/* Grid Tanggal */}
        <div className="grid grid-cols-7 gap-2">
          {renderCalendarDays()}
        </div>
      </div>

      {/* BAGIAN KANAN: DETAIL HARI INI */}
      <div className="w-80 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <h3 className="text-lg font-bold text-gray-800 mb-4">Jadwal Terpilih</h3>
        
        <div className="mb-6 pb-6 border-b border-gray-100">
          <div className="text-4xl font-bold text-red-500">{selectedDate.getDate()}</div>
          <div className="text-gray-500 font-medium">
            {months[selectedDate.getMonth()]} {selectedDate.getFullYear()}
          </div>
        </div>

        <div className="flex-1 overflow-y-auto">
          {/* Cek apakah ada event di tanggal yang dipilih */}
          {events.filter(e => e.date === selectedDate.getDate()).length > 0 ? (
            events
            .filter(e => e.date === selectedDate.getDate())
            .map((event, idx) => (
              <div key={idx} className="mb-3 p-3 bg-pink-50 rounded-lg border-l-4 border-red-400">
                <p className="font-bold text-gray-800 text-sm">{event.title}</p>
                <span className="text-xs text-red-500 bg-white px-2 py-0.5 rounded-full mt-1 inline-block uppercase">
                  {event.type}
                </span>
              </div>
            ))
          ) : (
            <div className="text-center text-gray-400 mt-10">
              <p>Tidak ada kegiatan akademik</p>
              <p className="text-xs mt-2">Santai dulu, tidak ada tugas.</p>
            </div>
          )}
        </div>
        
        <button className="w-full mt-4 bg-gray-800 text-white py-3 rounded-xl text-sm font-semibold hover:bg-gray-700 transition">
          + Tambah Catatan
        </button>
      </div>
    </div>
  );
};

export default Kalender;