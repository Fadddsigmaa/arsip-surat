<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bagian Header Profil (Cover & Avatar) --}}
            <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
                {{-- Foto Sampul/Cover (Gradient) --}}
                <div class="h-40 bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-600 w-full"></div>
                
                <div class="px-8 pb-6">
                    <div class="relative -mt-12 flex justify-between items-end">
                        {{-- Avatar Inisial Nama --}}
                        <div class="w-24 h-24 bg-white rounded-full p-1 border-4 border-white shadow-md">
                            <div class="w-full h-full rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-4xl font-bold uppercase">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        {{-- Label Status --}}
                        <span class="px-4 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-full border border-emerald-200 shadow-sm"> Akun Aktif </span>
                    </div>
                    
                    <div class="mt-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                        <p class="text-sm text-gray-500 font-medium">{{ Auth::user()->email }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded uppercase font-bold tracking-wider">
                                Member sejak {{ Auth::user()->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid Form Pengaturan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Form Informasi Profil --}}
                <div class="bg-white p-6 sm:p-8 shadow-sm rounded-2xl border border-gray-100 transition hover:shadow-md">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Informasi Pribadi</h2>
                            <p class="text-xs text-gray-500">Perbarui nama dan alamat email akun Anda.</p>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Form Ganti Password --}}
                <div class="bg-white p-6 sm:p-8 shadow-sm rounded-2xl border border-gray-100 transition hover:shadow-md">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Keamanan Akun</h2>
                            <p class="text-xs text-gray-500">Pastikan akun Anda menggunakan kata sandi yang kuat.</p>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Hapus Akun (Spans 2 columns on Desktop) --}}
                <div class="bg-white p-6 sm:p-8 shadow-sm rounded-2xl border border-gray-100 transition hover:shadow-md md:col-span-2 border-l-4 border-l-red-500">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-red-600">Zona Berbahaya</h2>
                            <p class="text-xs text-gray-500">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>