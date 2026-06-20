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
        // Tabel tetap menggunakan nama 'pemkes' sesuai permintaan Anda
        Schema::create('pemkes', function (Blueprint $table) {
            // Primary key sesuai ERD
            $table->id('id_pemkes');
            
            // Foreign Key ke tabel 'rat'
            $table->foreignId('id_rat')->constrained('rat', 'id_rat')->onDelete('cascade');
            
            // Atribut berdasarkan ERD aplikasi AKURAT
            $table->decimal('skor_pemkes', 5, 2);
            $table->decimal('skor_jpfk', 5, 2);
            $table->string('status_kesehatan');
            $table->text('catatan_jpfk')->nullable();
            $table->string('tahun_penilaian', 4);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemkes');
    }
};