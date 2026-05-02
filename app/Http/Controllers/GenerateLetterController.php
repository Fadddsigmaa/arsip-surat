<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Letter;
use SimpleSoftwareIO\QrCode\Facades\QrCode; 

class GenerateLetterController extends Controller
{
    // Method untuk menampilkan halaman form
    public function create()
    {
        return view('surat.create');
    }
    public function generate(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_tujuan' => 'required',
            'isi_surat' => 'required'
        ]);

        try {
            $nomorSurat = 'GEN-' . now()->format('YmdHis');
            $fileName = 'surat-keluar-' . time() . '.pdf';
            $path = 'arsip_surat/' . $fileName;
// 2. Generate QR Code (Menggunakan API Eksternal agar otomatis jadi PNG tanpa error Imagick)
            $teksQr = "Dokumen Resmi PT. Teknologi Masa Depan.\nNomor: " . $nomorSurat . "\nTujuan: " . $request->nama_tujuan;
            
            // Kita tembak ke API, ambil gambarnya, lalu ubah ke Base64 agar bisa dibaca DOMPDF
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($teksQr);
            $qrCodeImage = base64_encode(file_get_contents($qrUrl));

            // 3. Masukkan data & QR ke Template
            $data = [
                'nomor_surat' => $nomorSurat,
                'nama_tujuan' => $request->nama_tujuan,
                'tanggal' => now()->format('d F Y'),
                'isi_surat' => $request->isi_surat,
                'qrcode' => $qrCodeImage 
            ];

            // 3. Masukkan data & QR ke Template
            $data = [
                'nomor_surat' => $nomorSurat,
                'nama_tujuan' => $request->nama_tujuan,
                'tanggal' => now()->format('d F Y'),
                'isi_surat' => $request->isi_surat,
                'qrcode' => $qrCodeImage 
            ];

            // 4. Proses PDF
            $pdf = Pdf::loadView('surat.template1', $data);
            Storage::disk('public')->put($path, $pdf->output());

            // 5. Simpan ke Database
            Letter::create([
                'nomor_surat' => $nomorSurat,
                'judul' => 'Surat Otomatis: ' . $request->nama_tujuan,
                'jenis' => 'Keluar',
                'tanggal_surat' => now(),
                'file_path' => $path,
                'keterangan' => 'Digenerate otomatis oleh sistem.'
            ]);

            return redirect()->route('letters.index')->with('success', 'Surat berhasil digenerate lengkap dengan QR Code!');

        } catch (\Exception $e) {
            Log::error('Error generate: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses surat: ' . $e->getMessage());
        }
    }
}