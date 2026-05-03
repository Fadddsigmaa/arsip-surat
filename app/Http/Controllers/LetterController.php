<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\LetterNotification;
use App\Exports\LettersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Letter;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    /**
     * Mengirim email notifikasi arsip
     */
    public function sendEmail(Request $request, Letter $letter)
    {
        $request->validate(['email_tujuan' => 'required|email']);
        
        Mail::to($request->email_tujuan)->send(new LetterNotification($letter));

        return redirect()->back()->with('success', 'Email berhasil dikirim ke ' . $request->email_tujuan);
    }

    /**
     * 1. Method untuk menampilkan daftar arsip dengan filter & pencarian
     */
    public function index(Request $request)
    {
        // Memulai query kosong
        $query = Letter::query();

        // 1. Filter Pencarian Teks (Nomor / Judul)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nomor_surat', 'like', '%' . $request->search . '%')
                  ->orWhere('judul', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Filter Jenis Surat (Masuk/Keluar)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // 3. Filter Rentang Tanggal (Dari Tanggal s/d Sampai Tanggal)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_surat', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            // Jika hanya mengisi tanggal mulai
            $query->whereDate('tanggal_surat', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            // Jika hanya mengisi tanggal akhir
            $query->whereDate('tanggal_surat', '<=', $request->end_date);
        }

        // Eksekusi query dengan urutan terbaru dan pagination
        $letters = $query->orderBy('tanggal_surat', 'desc')->paginate(10);

        return view('letters.index', compact('letters'));
    }

    /**
     * 2. Method untuk menampilkan form tambah
     */
    public function create()
    {
        return view('letters.create');
    }

    /**
     * 3. Method untuk menyimpan data (Arsip Manual)
     */
    /**
     * 3. Method untuk menyimpan data (Arsip Manual)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|unique:letters',
            'judul' => 'required',
            'jenis' => 'required|in:Masuk,Keluar',
            'kop_surat' => 'required|string', // Validasi sudah benar
            'file_surat' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            $filePath = $request->file('file_surat')->store('arsip_surat', 'public');

            Letter::create([
                'nomor_surat' => $request->nomor_surat,
                'judul' => $request->judul,
                'jenis' => $request->jenis,
                'kop_surat' => $request->kop_surat, // <--- TAMBAHKAN BARIS INI AGAR TERSIMPAN
                'tanggal_surat' => now(),
                'file_path' => $filePath,
                'keterangan' => 'Arsip manual'
            ]);

            return redirect()->route('letters.index')->with('success', 'Arsip berhasil disimpan!');

        } catch (\Exception $e) {
            Log::error('Error upload arsip: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat mengunggah file.');
        }
    }
    /**
     * 4. Method untuk menghapus data (Soft Delete / Pindah ke Tong Sampah)
     */
    public function destroy(Letter $letter)
    {
        // KEAMANAN GANDA: Cek di Controller apakah user benar-benar Admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak: Hanya Admin yang boleh menghapus arsip!');
        }

        try {
            // Hapus data dari database (otomatis jadi Soft Delete / masuk tong sampah)
            $letter->delete();

            return redirect()->route('letters.index')->with('success', 'Arsip berhasil dipindah ke Tong Sampah.');
            
        } catch (\Exception $e) {
            Log::error('Error saat memindahkan arsip: ' . $e->getMessage());
            return back()->with('error', 'Gagal memindahkan data ke Tong Sampah.');
        }
    }

    /**
     * 5. Method untuk mengunduh Excel
     */
    public function exportExcel(Request $request) 
    {
        // Kirim semua input filter ($request) ke dalam class LettersExport
        return Excel::download(new LettersExport($request), 'Laporan_Filtered.xlsx');
    }

    // ==========================================
    // FITUR TONG SAMPAH (TRASH)
    // ==========================================

    /**
     * 6. Menampilkan halaman Tong Sampah
     */
    public function trash()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak');
        }
        
        $letters = Letter::onlyTrashed()->get();
        return view('letters.trash', compact('letters'));
    }

    /**
     * 7. Mengembalikan data dari Tong Sampah (Restore)
     */
    public function restore($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak');
        }

        $letter = Letter::onlyTrashed()->findOrFail($id);
        $letter->restore();
        
        return redirect()->back()->with('success', 'Arsip berhasil dipulihkan!');
    }

    /**
     * 8. Menghapus data & file fisik SELAMANYA
     */
    public function forceDelete($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak');
        }

        $letter = Letter::onlyTrashed()->findOrFail($id);

        try {
            // Hapus file fisik PDF-nya di sini
            if ($letter->file_path && Storage::disk('public')->exists($letter->file_path)) {
                Storage::disk('public')->delete($letter->file_path);
            }

            // Hapus permanen dari database
            $letter->forceDelete(); 
            
            return redirect()->back()->with('success', 'Arsip dan file fisik dihapus permanen!');
            
        } catch (\Exception $e) {
            Log::error('Error saat menghapus permanen arsip: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data secara permanen.');
        }
    }

    /**
     * 9. Method untuk melihat Log Aktivitas
     */
    public function logs() 
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak');
        }

        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('letters.logs', compact('logs'));
    }
}