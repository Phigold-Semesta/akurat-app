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
        // Menggunakan nama tabel tunggal: 'laporan'
        Schema::create('laporan', function (Blueprint $table) {
            // Menggunakan id_laporan sebagai primary key
            $table->id('id_laporan');
            
            // Foreign Keys
            $table->foreignId('id_rat')->constrained('rat', 'id_rat')->onDelete('cascade');
            $table->foreignId('id_pimpinan')->nullable()->constrained('pimpinan', 'id_pimpinan')->onDelete('set null');
            
            // Atribut berdasarkan ERD aplikasi AKURAT
            $table->date('tgl_laporan');
            $table->string('jenis_laporan');
            $table->string('status_laporan');
            $table->text('catatan_revisi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};