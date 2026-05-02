<x-mail::message>
# Halo, Berikut adalah Lampiran Arsip Surat

Halo, Anda menerima kiriman dokumen arsip surat dari sistem **E-Arsip**.

**Detail Surat:**
- **Nomor:** {{ $letter->nomor_surat }}
- **Judul:** {{ $letter->judul }}
- **Jenis:** {{ $letter->jenis }}
- **Tanggal:** {{ \Carbon\Carbon::parse($letter->tanggal_surat)->format('d F Y') }}

File PDF surat telah kami lampirkan pada email ini.

Terima kasih,<br>
Tim Administrasi {{ config('app.name') }}
</x-mail::message>