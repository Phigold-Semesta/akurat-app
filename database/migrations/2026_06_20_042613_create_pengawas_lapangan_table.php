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
        // Menggunakan nama tabel tunggal: 'pengawas_lapangan'
        Schema::create('pengawas_lapangan', function (Blueprint $table) {
            // Menggunakan id_pengawas sebagai primary key sesuai ERD
            $table->id('id_pengawas');
            
            // Relasi ke tabel 'user' (Foreign Key)
            $table->foreignId('id_user')->constrained('user', 'id_user')->onDelete('cascade');
            
            // Atribut lainnya berdasarkan ERD
            $table->string('nama_pengawas');
            $table->string('no_telp', 20);
            $table->string('wilayah_tugas');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawas_lapangan');
    }
};