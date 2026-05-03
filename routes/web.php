<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\GenerateLetterController;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Mengarahkan halaman awal langsung ke tabel arsip
    return redirect()->route('letters.index');
});

// ROUTE DASHBOARD (Sudah diperbaiki, tidak bertumpuk lagi)
Route::get('/dashboard', function () {
    // 1. Data Statistik Atas (Kartu)
    $totalSurat = Letter::count();
    $suratMasuk = Letter::where('jenis', 'Masuk')->count();
    $suratKeluar = Letter::where('jenis', 'Keluar')->count();

    // 2. Data untuk Grafik (Menghitung surat per bulan di tahun ini)
    $tahunIni = date('Y');
    $grafikData = Letter::selectRaw('MONTH(tanggal_surat) as bulan, jenis, COUNT(*) as jumlah')
        ->whereYear('tanggal_surat', $tahunIni)
        ->groupBy('bulan', 'jenis')
        ->get();

    // 3. Menyiapkan Array Kosong untuk 12 Bulan
    $labelBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    $dataSuratMasuk = array_fill(0, 12, 0); 
    $dataSuratKeluar = array_fill(0, 12, 0);

    // 4. Memasukkan data dari database ke array bulan yang sesuai
    foreach ($grafikData as $data) {
        $indeksBulan = $data->bulan - 1; // Karena array dimulai dari 0
        if ($data->jenis == 'Masuk') {
            $dataSuratMasuk[$indeksBulan] = $data->jumlah;
        } else {
            $dataSuratKeluar[$indeksBulan] = $data->jumlah;
        }
    }

    return view('dashboard', compact(
        'totalSurat', 'suratMasuk', 'suratKeluar', 
        'labelBulan', 'dataSuratMasuk', 'dataSuratKeluar', 'tahunIni'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');


// GRUP ROUTE YANG MEMBUTUHKAN LOGIN
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ROUTE TONG SAMPAH (Admin)
    Route::get('/letters/trash', [LetterController::class, 'trash'])->name('letters.trash');
    Route::post('/letters/{id}/restore', [LetterController::class, 'restore'])->name('letters.restore');
    Route::delete('/letters/{id}/force-delete', [LetterController::class, 'forceDelete'])->name('letters.forceDelete');

    // ROUTE LOG AKTIVITAS (Admin)
    Route::get('/admin/logs', [LetterController::class, 'logs'])->name('letters.logs');

    // ROUTE SISTEM ARSIP KITA
    Route::resource('letters', LetterController::class);
    Route::get('/letters/export/excel', [LetterController::class, 'exportExcel'])->name('letters.export');
    Route::post('/letters/{letter}/send-email', [LetterController::class, 'sendEmail'])->name('letters.sendEmail');
    
    // ROUTE GENERATE SURAT
    Route::get('/generate-surat', [GenerateLetterController::class, 'create'])->name('surat.create');
    Route::post('/generate-surat', [GenerateLetterController::class, 'generate'])->name('surat.generate');
});


// ROUTE TESTING
Route::get('/test-generate', function(Request $request) {
    $request->merge([
        'nama_tujuan' => 'Bapak Budi Santoso',
        'isi_surat' => 'Kami mengundang Anda untuk hadir dalam rapat direksi minggu depan.'
    ]);
    return app(GenerateLetterController::class)->generate($request);
});

require __DIR__.'/auth.php';