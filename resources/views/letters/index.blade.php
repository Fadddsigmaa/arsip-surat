<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Arsip Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="mb-6 space-y-4">
                
                {{-- Kumpulan Tombol Aksi --}}
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('letters.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-150 ease-in-out">
                        + Arsip Manual
                    </a>
                    <a href="{{ route('surat.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-150 ease-in-out">
                        + Generate Otomatis
                    </a>
                   <a href="{{ route('letters.export', request()->all()) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded shadow">
                        📊 Export Excel
                    </a>
                    
                    {{-- Tombol Tong Sampah (Hanya Admin) --}}
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('letters.trash') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded shadow transition duration-150 ease-in-out">
                            🗑️ Tong Sampah
                        </a>
                    @endif
                </div>

                {{-- Form Pencarian & Filter --}}
                <form action="{{ route('letters.index') }}" method="GET" class="w-full bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Kata Kunci</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor / judul..." 
                                   class="w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Jenis Surat</label>
                            <select name="jenis" class="w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Semua Jenis</option>
                                <option value="Masuk" {{ request('jenis') == 'Masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                <option value="Keluar" {{ request('jenis') == 'Keluar' ? 'selected' : '' }}>Surat Keluar</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                                   class="w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <div class="flex gap-2">
                                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                                       class="w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-semibold transition duration-150 text-sm">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    @if(request('search') || request('jenis') || request('start_date') || request('end_date'))
                        <div class="mt-3 flex justify-end">
                            <a href="{{ route('letters.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium underline flex items-center gap-1">
                                ✖ Hapus Semua Filter
                            </a>
                        </div>
                    @endif
                </form>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full whitespace-nowrap">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul / Perihal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($letters as $letter)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $letter->nomor_surat }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $letter->judul }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($letter->jenis == 'Masuk')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            Masuk
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                            Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($letter->tanggal_surat)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-center font-medium">
                                    <div class="flex items-center justify-center gap-3">
                                        {{-- Tombol Lihat --}}
                                        <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-semibold">
                                            Lihat
                                        </a>

                                        {{-- Form Kirim Email --}}
                                        <form action="{{ route('letters.sendEmail', $letter->id) }}" method="POST" class="inline-flex items-center gap-1">
                                            @csrf
                                            <input type="email" name="email_tujuan" placeholder="Kirim ke email..." required 
                                                   class="text-xs border-gray-300 rounded p-1 w-32 focus:ring-0 focus:border-blue-400">
                                            <button type="submit" class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs font-bold hover:bg-blue-200 transition">
                                                Kirim
                                            </button>
                                        </form>
                                        
                                        {{-- Tombol Hapus (Hanya Admin) --}}
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('letters.destroy', $letter->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan arsip ini ke Tong Sampah?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data arsip surat yang ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($letters->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $letters->appends(request()->query())->links() }}
                </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>