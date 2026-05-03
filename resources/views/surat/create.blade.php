<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Surat Otomatis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('surat.generate') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="kop_surat">
                                Pilih Kop Surat
                            </label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                    id="kop_surat" name="kop_surat" required>
                                {{-- Ubah value pt_teknologi menjadi hmti --}}
                                <option value="hmti" {{ old('kop_surat') == 'hmti' ? 'selected' : '' }}>Kop HMTI Universitas Ibnu Sina</option>
                                <option value="gmni" {{ old('kop_surat') == 'gmni' ? 'selected' : '' }}>Kop GMNI Kota Batam</option>
                            </select>
                            @error('kop_surat') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_tujuan">
                                Nama Tujuan / Penerima
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                   id="nama_tujuan" type="text" name="nama_tujuan" placeholder="Contoh: Bapak Budi Santoso" value="{{ old('nama_tujuan') }}" required>
                            @error('nama_tujuan') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="isi_surat">
                                Isi Surat Utama
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                      id="isi_surat" name="isi_surat" rows="6" placeholder="Ketikkan isi pesan surat Anda di sini..." required>{{ old('isi_surat') }}</textarea>
                            @error('isi_surat') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Buat & Simpan Surat
                            </button>
                            <a href="{{ route('letters.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>