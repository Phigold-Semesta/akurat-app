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
        // Menggunakan nama tabel tunggal: 'sertifikat'
        Schema::create('sertifikat', function (Blueprint $table) {
            // Menggunakan id_sertifikat sebagai primary key sesuai ERD
            $table->id('id_sertifikat');
            
            // Foreign Key ke tabel 'rat'
            $table->foreignId('id_rat')->constrained('rat', 'id_rat')->onDelete('cascade');
            
            // Atribut berdasarkan ERD aplikasi AKURAT
            $table->string('nomor_sertifikat')->unique();
            $table->date('tgl_terbit');
            $table->string('file_sertifikat');
            $table->string('qr_code_path');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};