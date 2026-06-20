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
        // Menggunakan nama tabel tunggal: 'verifikasi_rat'
        Schema::create('verifikasi_rat', function (Blueprint $table) {
            // Menggunakan id_verifikasi sebagai primary key sesuai ERD
            $table->id('id_verifikasi');
            
            // Foreign Keys (Relasi ke RAT dan Pengawas)
            $table->foreignId('id_rat')->constrained('rat', 'id_rat')->onDelete('cascade');
            $table->foreignId('id_pengawas')->constrained('pengawas_lapangan', 'id_pengawas')->onDelete('cascade');
            
            // Atribut berdasarkan ERD aplikasi AKURAT
            $table->date('tgl_verifikasi');
            $table->string('status_validasi');
            $table->text('rekomendasi')->nullable();
            $table->string('file_ba_verifikasi')->nullable(); // File Berita Acara
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_rat');
    }
};