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
        // Menggunakan nama tabel tunggal: 'rat'
        Schema::create('rat', function (Blueprint $table) {
            // Menggunakan id_rat sebagai primary key sesuai ERD
            $table->id('id_rat');
            
            // Foreign Keys
            $table->foreignId('id_koperasi')->constrained('koperasi', 'id_koperasi')->onDelete('cascade');
            $table->foreignId('id_pimpinan')->nullable()->constrained('pimpinan', 'id_pimpinan')->onDelete('set null');
            
            // Atribut berdasarkan ERD aplikasi AKURAT
            $table->string('tahun_buku', 4);
            $table->date('tgl_rat');
            $table->string('tempat_rat');
            $table->integer('jumlah_peserta');
            $table->text('hasil_rat')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rat');
    }
};