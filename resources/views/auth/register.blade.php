<x-guest-layout>
    <div class="flex h-screen w-full bg-gray-50 font-sans fixed inset-0 z-50">
        
        {{-- Sisi Kiri (Sama dengan Login untuk konsistensi) --}}
        <div class="hidden lg:flex flex-col justify-center items-center w-1/2 bg-gradient-to-br from-indigo-700 via-purple-600 to-blue-800 text-white p-12 relative overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="z-10 text-center">
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight text-white">Gabung Bersama<br>E-Office<span class="text-blue-300">App</span></h1>
                <p class="text-lg text-indigo-100 max-w-md mx-auto leading-relaxed">Mulai digitalisasi arsip Anda dalam hitungan menit. Cepat, aman, dan terintegrasi.</p>
            </div>
        </div>

        {{-- Sisi Kanan: Form Register --}}
        <div class="flex flex-col justify-center items-center w-full lg:w-1/2 p-8 sm:p-12 overflow-y-auto">
            <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border border-gray-100 mt-20 mb-20 lg:mt-0 lg:mb-0">
                
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
                    <p class="text-sm text-gray-500 mt-2">Lengkapi data di bawah untuk mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full bg-gray-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Alamat Email')" />
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-50" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-50" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-8">
                        <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200">
                            {{ __('Daftar Akun Sekarang') }}
                        </x-primary-button>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Masuk di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>