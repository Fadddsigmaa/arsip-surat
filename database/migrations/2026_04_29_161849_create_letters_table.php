<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('letters', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_surat')->unique();
        $table->string('judul');
        $table->enum('jenis', ['Masuk', 'Keluar']);
        $table->date('tanggal_surat');
        $table->string('file_path')->nullable(); // Untuk path file PDF/Word
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
