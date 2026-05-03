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
    Schema::table('letters', function (Blueprint $table) {
        // Menambahkan kolom string, default-nya pakai kop 'pt_teknologi'
        $table->string('kop_surat')->default('pt_teknologi')->after('jenis'); 
    });
    }

    public function down(): void
    {
    Schema::table('letters', function (Blueprint $table) {
        $table->dropColumn('kop_surat');
    });
    }
};
