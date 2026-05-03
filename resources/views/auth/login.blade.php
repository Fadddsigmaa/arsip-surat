<x-guest-layout>
    <div class="flex h-screen w-full bg-gray-50 font-sans fixed inset-0 z-50">
        {{-- Sisi Kiri: Branding & Visual --}}
        <div class="hidden lg:flex flex-col justify-center items-center w-1/2 bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-800 text-white p-12 relative overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-300 opacity-20 rounded-full blur-3xl"></div>
            
            <div class="z-10 text-center">
                <div class="inline-flex p-4 bg-white/10 rounded-2xl backdrop-blur-md mb-6 border border-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight">E-Office<span class="text-blue-300">App</span></h1>
                <p class="text-lg text-blue-100 max-w-md mx-auto leading-relaxed">Sistem Manajemen Arsip dan Pembuatan Surat Digital Cerdas untuk Produktivitas Instansi Anda.</p>
            </div>
        </div>

        {{-- Sisi Kanan: Form Login --}}
        <div class="flex flex-col justify-center items-center w-full lg:w-1/2 p-8 sm:p-12 overflow-y-auto">
            <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali</h2>
                    <p class="text-sm text-gray-500 mt-2">Silakan masukkan kredensial akun Anda.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:ring-blue-500 focus:border-blue-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <div class="flex justify-between items-center">
                            <x-input-label for="password" :value="__('Password')" />
                            @if (Route::has('password.request'))
                                <a class="text-xs text-blue-600 hover:underline" href="{{ route('password.request') }}">Lupa Password?</a>
                            @endif
                        </div>
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:ring-blue-500 focus:border-blue-500" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya di perangkat ini') }}</span>
                        </label>
                    </div>

                    <div class="mt-8">
                        <x-primary-button class="w-full justify-center py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition duration-200 shadow-lg shadow-blue-200">
                            {{ __('Masuk ke Dashboard') }}
                        </x-primary-button>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Daftar Sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
            
            <p class="text-sm text-gray-400 mt-8">
                &copy; {{ date('Y') }} PT Teknologi Masa Depan. All rights reserved.
            </p>
        </div>
    </div>
</x-guest-layout>