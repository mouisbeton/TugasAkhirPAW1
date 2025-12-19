@component('layouts.student-panel')
    
    <div class="h-full flex flex-col items-center justify-center text-center space-y-4">
        
        <div class="bg-red-50 p-6 rounded-full mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-active-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-800">
            Selamat Datang, {{ Auth::user()->name }}!
        </h2>
        
        <p class="text-gray-500 max-w-md">
            Selamat datang di Sistem Kelola Akademik. Silakan pilih menu di samping untuk melihat pesan atau kalender.
        </p>

    </div>

@endcomponent