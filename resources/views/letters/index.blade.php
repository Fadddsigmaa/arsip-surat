<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Arsip Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Notifikasi --}}
            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 shadow-sm rounded-r-lg" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="mb-6 space-y-4">
                
                {{-- Kumpulan Tombol Aksi --}}
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('letters.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                        + Arsip Manual
                    </a>
                    <a href="{{ route('surat.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                        + Generate Otomatis
                    </a>
                    <a href="{{ route('letters.export', request()->all()) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                        📊 Export Excel
                    </a>
                    
                    {{-- Tombol Tong Sampah (Hanya Admin) --}}
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('letters.trash') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                            🗑️ Tong Sampah
                        </a>
                    @endif
                </div>

                {{-- Form Pencarian & Filter --}}
                <form action="{{ route('letters.index') }}" method="GET" class="w-full bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">Kata Kunci</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor / judul..." 
                                   class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">Jenis Surat</label>
                            <select name="jenis" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition">
                                <option value="">Semua Jenis</option>
                                <option value="Masuk" {{ request('jenis') == 'Masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                <option value="Keluar" {{ request('jenis') == 'Keluar' ? 'selected' : '' }}>Surat Keluar</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                                   class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">Sampai Tanggal</label>
                            <div class="flex gap-2">
                                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                                       class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition duration-150 text-sm">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    @if(request('search') || request('jenis') || request('start_date') || request('end_date'))
                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('letters.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium hover:underline flex items-center gap-1 transition">
                                ✖ Hapus Semua Filter
                            </a>
                        </div>
                    @endif
                </form>

            </div>

            {{-- Desain Tabel Clean dengan Badges --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Surat</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul / Perihal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($letters as $letter)
                            <tr class="hover:bg-blue-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                    {{ $letter->nomor_surat }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                    {{ $letter->judul }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($letter->jenis == 'Masuk')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 shadow-sm border border-emerald-200">
                                            Surat Masuk
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 shadow-sm border border-blue-200">
                                            Surat Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    {{ \Carbon\Carbon::parse($letter->tanggal_surat)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        
                                        {{-- Tombol Lihat (Gaya Soft) --}}
                                        <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-md transition font-semibold">
                                            Lihat PDF
                                        </a>

                                        {{-- Form Kirim Email (Dipercantik) --}}
                                        <form action="{{ route('letters.sendEmail', $letter->id) }}" method="POST" class="inline-flex items-center gap-1 bg-gray-50 p-1 rounded-md border border-gray-200">
                                            @csrf
                                            <input type="email" name="email_tujuan" placeholder="Kirim ke email..." required 
                                                   class="text-xs border-transparent bg-transparent rounded p-1 w-32 focus:ring-0 focus:border-transparent">
                                            <button type="submit" class="bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded text-xs font-bold hover:bg-indigo-200 transition">
                                                Kirim
                                            </button>
                                        </form>
                                        
                                        {{-- Tombol Hapus (Gaya Soft - Hanya Admin) --}}
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('letters.destroy', $letter->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan arsip ini ke Tong Sampah?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-700 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-md transition font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 bg-gray-50 rounded-b-xl">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-4xl mb-2">📭</span>
                                        <p class="font-medium text-lg">Belum ada data arsip surat</p>
                                        <p class="text-sm text-gray-400 mt-1">Silakan tambah arsip baru atau ubah filter pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($letters->hasPages())
                <div class="px-6 py-4 bg-white border-t border-gray-100">
                    {{ $letters->appends(request()->query())->links() }}
                </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>