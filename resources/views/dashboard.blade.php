<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Statistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 text-lg font-medium">
                    👋 Selamat datang kembali, {{ Auth::user()->name }}! Berikut adalah ringkasan data arsip Anda.
                </div>
            </div>

            {{-- Grid Kartu Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-blue-500 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm uppercase tracking-wider font-semibold">Total Semua Arsip</p>
                            <h3 class="text-4xl font-bold mt-2">{{ $totalSurat }}</h3>
                        </div>
                        <div class="p-3 bg-blue-600 rounded-full text-2xl">
                            📁
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-blue-100 flex justify-between items-center">
                        <span>Keseluruhan Dokumen</span>
                        <a href="{{ route('letters.index') }}" class="hover:underline font-medium">Lihat Detail →</a>
                    </div>
                </div>

                <div class="bg-indigo-500 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm uppercase tracking-wider font-semibold">Surat Masuk</p>
                            <h3 class="text-4xl font-bold mt-2">{{ $suratMasuk }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-600 rounded-full text-2xl">
                            📥
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-indigo-100 flex justify-between items-center">
                        <span>Dokumen Diterima</span>
                        <a href="{{ route('letters.index', ['search' => 'Masuk']) }}" class="hover:underline font-medium">Lihat Detail →</a>
                    </div>
                </div>

                <div class="bg-emerald-500 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm uppercase tracking-wider font-semibold">Surat Keluar</p>
                            <h3 class="text-4xl font-bold mt-2">{{ $suratKeluar }}</h3>
                        </div>
                        <div class="p-3 bg-emerald-600 rounded-full text-2xl">
                            📤
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-emerald-100 flex justify-between items-center">
                        <span>Dokumen Diterbitkan</span>
                        <a href="{{ route('letters.index', ['search' => 'Keluar']) }}" class="hover:underline font-medium">Lihat Detail →</a>
                    </div>
                </div>

            </div> {{-- Akhir Grid Kartu Statistik --}}

            {{-- Grafik Statistik --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Statistik Arsip Surat Tahun {{ $tahunIni }}</h3>
                
                <div class="relative h-96 w-full">
                    <canvas id="arsipChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    {{-- Script Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('arsipChart').getContext('2d');
            
            // Menerima data dari Controller Laravel
            const labelBulan = @json($labelBulan);
            const dataMasuk = @json($dataSuratMasuk);
            const dataKeluar = @json($dataSuratKeluar);

            new Chart(ctx, {
                type: 'bar', 
                data: {
                    labels: labelBulan,
                    datasets: [
                        {
                            label: 'Surat Masuk',
                            data: dataMasuk,
                            backgroundColor: 'rgba(99, 102, 241, 0.7)', // Indigo
                            borderColor: 'rgba(99, 102, 241, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Surat Keluar',
                            data: dataKeluar,
                            backgroundColor: 'rgba(16, 185, 129, 0.7)', // Emerald
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>