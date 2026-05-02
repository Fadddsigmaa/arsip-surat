<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            🗑️ {{ __('Tong Sampah Arsip') }}
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

            <div class="mb-4">
                <a href="{{ route('letters.index') }}" class="text-blue-500 hover:text-blue-700 font-semibold transition duration-150 ease-in-out">
                    &larr; Kembali ke Daftar Arsip
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full whitespace-nowrap">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dihapus Pada</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($letters as $letter)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $letter->nomor_surat }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $letter->judul }}</td>
                                <td class="px-6 py-4 text-sm text-red-500">{{ $letter->deleted_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 text-sm text-center font-medium">
                                    
                                    {{-- Tombol Pulihkan (Teks Biru) --}}
                                    <form action="{{ route('letters.restore', $letter->id) }}" method="POST" class="inline-block mr-4">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 font-semibold transition duration-150 ease-in-out">
                                            Pulihkan
                                        </button>
                                    </form>

                                    {{-- Tombol Hapus Permanen (Teks Merah) --}}
                                    <form action="{{ route('letters.forceDelete', $letter->id) }}" method="POST" class="inline-block" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus arsip ini selamanya? File PDF juga akan terhapus dan TIDAK BISA KEMBALI!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold transition duration-150 ease-in-out">
                                            Hapus Permanen
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Tong sampah kosong.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>