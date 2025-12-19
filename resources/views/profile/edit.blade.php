@if(Auth::user()->role === 'dosen')

    @component('layouts.dosen-panel')

    <div class="h-full flex flex-col justify-center items-center">
        <div class="w-full max-w-2xl rounded-[20px] shadow-sm p-10" style="background-color: #E6DED6;">
            <div class="space-y-6 text-xl text-gray-800 font-medium font-sans">
                <div class="flex items-start">
                    <span class="font-bold w-40">Nama</span>
                    <span>: {{ Auth::user()->name }}</span>
                </div>
                <div class="flex items-start">
                    <span class="font-bold w-40">Status</span>
                    <span>: {{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <div class="flex items-start">
                    <span class="font-bold w-40">Email</span>
                    <span>: {{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-[#9F3E28] text-sm font-bold transition">
                    Logout Akun
                </button>
            </form>
        </div>
    </div>
    @endcomponent

@else

    @php
        // LOGIKA PEMILIHAN LAYOUT YANG BENAR
        if(Auth::user()->role === 'mahasiswa') {
            $layout = 'layouts.student-panel';
        } elseif(Auth::user()->role === 'admin') {
            $layout = 'layouts.admin-panel'; // Admin pakai layout admin
        } else {
            $layout = 'layouts.app'; // Fallback default
        }
    @endphp

    @component($layout)
        
        @if($layout === 'layouts.app')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>
        @endif

        <div class="{{ Auth::user()->role === 'admin' ? 'h-full flex flex-col gap-6' : (Auth::user()->role === 'mahasiswa' ? '' : 'py-12') }}">
            
            <div class="{{ Auth::user()->role === 'admin' ? '' : (Auth::user()->role === 'mahasiswa' ? 'space-y-6' : 'max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6') }}">
                
                @if(Auth::user()->role !== 'dosen')
                <div class="flex justify-between items-center {{ Auth::user()->role === 'admin' ? 'mb-0' : 'mb-4' }}">
                    <h2 class="font-bold text-2xl text-gray-800">
                        {{ Auth::user()->role === 'admin' ? 'Pengaturan Akun Admin' : 'Pengaturan Profil' }}
                    </h2>
                </div>
                @endif

                <div class="p-6 sm:p-8 bg-white shadow-sm border border-gray-100 rounded-[20px] {{ Auth::user()->role === 'admin' ? 'mb-6' : '' }}">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900">Informasi Profil</h2>
                            <p class="mt-1 text-sm text-gray-600">Perbarui nama tampilan dan alamat email akun Anda.</p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="name">Nama</label>
                                <input class="border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm mt-1 block w-full py-3 px-4 bg-gray-50" 
                                       id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                                @error('name') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="email">Email</label>
                                <input class="border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm mt-1 block w-full py-3 px-4 bg-gray-50" 
                                       id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                                @error('email') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150">
                                    Simpan Profil
                                </button>
                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-bold">
                                        ✓ Tersimpan.
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="p-6 sm:p-8 bg-white shadow-sm border border-gray-100 rounded-[20px]">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900">Update Password</h2>
                            <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda aman dengan password yang kuat.</p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="current_password">Password Saat Ini</label>
                                <input class="border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm mt-1 block w-full py-3 px-4 bg-gray-50" 
                                       id="current_password" name="current_password" type="password" autocomplete="current-password" />
                                @error('current_password') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="password">Password Baru</label>
                                <input class="border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm mt-1 block w-full py-3 px-4 bg-gray-50" 
                                       id="password" name="password" type="password" autocomplete="new-password" />
                                @error('password') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="password_confirmation">Konfirmasi Password</label>
                                <input class="border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm mt-1 block w-full py-3 px-4 bg-gray-50" 
                                       id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                                @error('password_confirmation') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150">
                                    Update Password
                                </button>
                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-bold">
                                        ✓ Password Berhasil.
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @endcomponent

@endif