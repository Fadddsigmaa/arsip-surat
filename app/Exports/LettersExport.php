<?php

namespace App\Exports;

use App\Models\Letter;
use Maatwebsite\Excel\Concerns\FromQuery; // Ubah dari FromCollection ke FromQuery agar lebih powerful
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LettersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    // Properti untuk menampung filter
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * Melakukan Query berdasarkan filter yang aktif
    */
    public function query()
    {
        $query = Letter::query();

        // Terapkan filter yang sama persis dengan di Controller
        if ($this->request->filled('search')) {
            $query->where(function($q) {
                $q->where('nomor_surat', 'like', '%' . $this->request->search . '%')
                  ->orWhere('judul', 'like', '%' . $this->request->search . '%');
            });
        }

        if ($this->request->filled('jenis')) {
            $query->where('jenis', $this->request->jenis);
        }

        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('tanggal_surat', [$this->request->start_date, $this->request->end_date]);
        }

        return $query->orderBy('tanggal_surat', 'desc');
    }

    public function headings(): array
    {
        return ['ID', 'Nomor Surat', 'Judul', 'Jenis', 'Tanggal Surat', 'Dibuat Pada'];
    }

    public function map($letter): array
    {
        return [
            $letter->id,
            $letter->nomor_surat,
            $letter->judul,
            $letter->jenis,
            \Carbon\Carbon::parse($letter->tanggal_surat)->format('d F Y'),
            $letter->created_at->format('d/m/Y H:i')
        ];
    }
}