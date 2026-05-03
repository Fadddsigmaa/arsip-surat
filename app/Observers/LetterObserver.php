<?php

namespace App\Observers;

use App\Models\Letter;
use App\Models\ActivityLog;

class LetterObserver
{
    public function created(Letter $letter): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Menambah',
            'description' => "Menambahkan arsip surat baru: {$letter->nomor_surat}"
        ]);
    }

    public function updated(Letter $letter): void
    {
        // Cek apakah ini soft delete (pindah ke tong sampah)
        $activity = $letter->isDirty('deleted_at') ? 'Membuang' : 'Mengubah';
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => $activity,
            'description' => "{$activity} arsip surat: {$letter->nomor_surat}"
        ]);
    }

    public function deleted(Letter $letter): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Menghapus Permanen',
            'description' => "Menghapus permanen arsip surat: {$letter->nomor_surat}"
        ]);
    }


    /**
     * Handle the Letter "restored" event.
     */
    public function restored(Letter $letter): void
    {
        //
    }

    /**
     * Handle the Letter "force deleted" event.
     */
    public function forceDeleted(Letter $letter): void
    {
        //
    }
}
