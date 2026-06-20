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
        // Menggunakan nama tabel tunggal: 'dokumen_rat'
        Schema::create('dokumen_rat', function (Blueprint $table) {
            // Menggunakan id_dokumen sebagai primary key sesuai ERD
            $table->id('id_dokumen');
            
            // Foreign Key ke tabel 'rat'
            $table->foreignId('id_rat')->constrained('rat', 'id_rat')->onDelete('cascade');
            
            // Atribut berdasarkan ERD aplikasi AKURAT
            $table->string('nama_dokumen');
            $table->string('file_path'); // Lokasi penyimpanan file
            $table->timestamp('tgl_upload')->useCurrent();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_rat');
    }
};