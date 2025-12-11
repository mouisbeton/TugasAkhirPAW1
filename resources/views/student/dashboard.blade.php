<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-blue-600">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mt-2 text-gray-600">Selamat datang di Sistem Akademik.</p>
                    
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="font-semibold">Status Akademik:</p>
                        <ul class="list-disc list-inside mt-2 text-sm text-gray-700">
                            <li>Angkatan: {{ Auth::user()->angkatan ?? '-' }}</li>
                            <li>Status: <span class="text-green-600 font-bold">Aktif</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>