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
                
                {{-- Kartu Total Arsip --}}
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-blue-100 text-sm font-semibold uppercase tracking-wider">Total Semua Arsip</p>
                            <h3 class="text-4xl font-bold mt-1">{{ $totalSurat }}</h3>
                        </div>
                        <svg class="w-12 h-12 text-blue-200 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="mt-4 text-sm text-blue-100 flex justify-between items-center border-t border-blue-400 pt-3">
                        <span>Keseluruhan Dokumen</span>
                        <a href="{{ route('letters.index') }}" class="hover:underline font-medium">Lihat Detail &rarr;</a>
                    </div>
                </div>

                {{-- Kartu Surat Masuk --}}
                <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-emerald-100 text-sm font-semibold uppercase tracking-wider">Surat Masuk</p>
                            <h3 class="text-4xl font-bold mt-1">{{ $suratMasuk }}</h3>
                        </div>
                        <svg class="w-12 h-12 text-emerald-200 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <div class="mt-4 text-sm text-emerald-100 flex justify-between items-center border-t border-emerald-400 pt-3">
                        <span>Dokumen Diterima</span>
                        <a href="{{ route('letters.index', ['search' => 'Masuk']) }}" class="hover:underline font-medium">Lihat Detail &rarr;</a>
                    </div>
                </div>

                {{-- Kartu Surat Keluar --}}
                <div class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-orange-100 text-sm font-semibold uppercase tracking-wider">Surat Keluar</p>
                            <h3 class="text-4xl font-bold mt-1">{{ $suratKeluar }}</h3>
                        </div>
                        <svg class="w-12 h-12 text-orange-200 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <div class="mt-4 text-sm text-orange-100 flex justify-between items-center border-t border-orange-400 pt-3">
                        <span>Dokumen Diterbitkan</span>
                        <a href="{{ route('letters.index', ['search' => 'Keluar']) }}" class="hover:underline font-medium">Lihat Detail &rarr;</a>
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
                            backgroundColor: 'rgba(16, 185, 129, 0.7)', // Emerald untuk senada dengan kartu
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Surat Keluar',
                            data: dataKeluar,
                            backgroundColor: 'rgba(245, 158, 11, 0.7)', // Amber/Orange untuk senada dengan kartu
                            borderColor: 'rgba(245, 158, 11, 1)',
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