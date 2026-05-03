<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Riwayat Sistem Terbaru</h2>
                
                {{-- Garis Utama Timeline --}}
                <div class="relative border-l-2 border-gray-100 ml-3 space-y-8">
                    
                    @forelse($logs as $log)
                        @php
                            // Logika dinamis untuk warna & ikon berdasarkan jenis aktivitas
                            $activityName = strtolower($log->activity);
                            $bgColor = 'bg-blue-500'; // Default warna biru
                            $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'; // Ikon Info
                            
                            if (str_contains($activityName, 'create') || str_contains($activityName, 'tambah') || str_contains($activityName, 'buat')) {
                                $bgColor = 'bg-emerald-500';
                                $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>'; // Ikon Plus
                            } elseif (str_contains($activityName, 'update') || str_contains($activityName, 'edit') || str_contains($activityName, 'ubah')) {
                                $bgColor = 'bg-amber-500';
                                $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>'; // Ikon Edit
                            } elseif (str_contains($activityName, 'delete') || str_contains($activityName, 'hapus')) {
                                $bgColor = 'bg-red-500';
                                $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>'; // Ikon Tong Sampah
                            }
                        @endphp

                        {{-- Item Timeline --}}
                        <div class="relative pl-8 hover:bg-gray-50 p-2 rounded-lg transition duration-150 -ml-2">
                            
                            {{-- Bulatan Penanda (Badge Ikon) --}}
                            <span class="absolute left-[-11px] top-3 {{ $bgColor }} ring-4 ring-white w-7 h-7 rounded-full flex items-center justify-center shadow-sm">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $icon !!}
                                </svg>
                            </span>
                            
                            {{-- Konten Log --}}
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                <div>
                                    <h3 class="text-base font-bold text-gray-800">
                                        {{ $log->user->name ?? 'User Telah Dihapus' }} 
                                        <span class="text-xs font-semibold text-gray-500 bg-gray-200 px-2 py-0.5 rounded-md ml-2 uppercase tracking-wider">
                                            {{ $log->activity }}
                                        </span>
                                    </h3>
                                </div>
                                {{-- Waktu Absolut & Relatif --}}
                                <div class="mt-1 sm:mt-0 flex flex-col sm:text-right">
                                    <time class="text-xs font-bold text-gray-600">
                                        {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') }}
                                    </time>
                                    <span class="text-xs text-gray-400 font-medium">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Deskripsi dibungkus kotak halus agar lebih rapi --}}
                            <div class="mt-2 text-sm text-gray-600 bg-gray-50 border border-gray-100 p-3 rounded-lg leading-relaxed inline-block w-full">
                                {{ $log->description }}
                            </div>

                        </div>
                    @empty
                        {{-- State Jika Kosong --}}
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4 opacity-50">⏱️</div>
                            <h3 class="text-lg font-bold text-gray-700">Belum Ada Aktivitas</h3>
                            <p class="text-gray-500">Sistem belum mencatat log aktivitas apapun saat ini.</p>
                        </div>
                    @endforelse

                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                <div class="mt-8 pt-4 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>