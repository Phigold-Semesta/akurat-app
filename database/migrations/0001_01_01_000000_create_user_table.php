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
        // Tabel utama 'user' sesuai dengan ERD dan aturan penamaan Anda
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user'); // Menggunakan id_user sebagai primary key
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role'); // Sesuai ERD (admin/koperasi/pengawas/pimpinan)
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel untuk reset password (tetap standar namun menggunakan tabel 'password_reset_token')
        Schema::create('password_reset_token', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabel session (menggunakan 'session' tunggal)
        Schema::create('session', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('id_user')->nullable()->index(); // Relasi ke id_user
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session');
        Schema::dropIfExists('password_reset_token');
        Schema::dropIfExists('user');
    }
};