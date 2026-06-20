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
        // Menggunakan nama tabel tunggal: 'koperasi'
        Schema::create('koperasi', function (Blueprint $table) {
            // Menggunakan id_koperasi sebagai primary key
            $table->id('id_koperasi');
            
            // Relasi ke tabel 'user' (Foreign Key)
            $table->foreignId('id_user')->constrained('user', 'id_user')->onDelete('cascade');
            
            // Atribut berdasarkan ERD aplikasi AKURAT
            $table->string('nama_koperasi');
            $table->string('no_badan_hukum', 50);
            $table->text('alamat');
            $table->string('kecamatan');
            $table->date('tgl_berdiri');
            $table->string('status_koperasi');
            $table->integer('jumlah_anggota');
            $table->string('ketua');
            $table->string('sekretaris');
            $table->string('bendahara');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasi');
    }
};