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
        // Menggunakan nama tabel tunggal: 'pimpinan'
        Schema::create('pimpinan', function (Blueprint $table) {
            // Menggunakan id_pimpinan sebagai primary key sesuai ERD
            $table->id('id_pimpinan');
            
            // Relasi ke tabel 'user' (Foreign Key)
            $table->foreignId('id_user')->constrained('user', 'id_user')->onDelete('cascade');
            
            // Atribut berdasarkan ERD aplikasi AKURAT
            $table->string('nama_pimpinan');
            $table->string('jabatan');
            $table->string('no_telp', 20);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pimpinan');
    }
};