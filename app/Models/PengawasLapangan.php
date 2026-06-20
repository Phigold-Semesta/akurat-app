<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengawasLapangan extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'pengawas_lapangan';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_pengawas';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_user',
        'nama_pengawas',
        'no_telp',
        'wilayah_tugas',
    ];

    /**
     * Relasi ke model User.
     * Pengawas memiliki akun login (User).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model VerifikasiRat.
     * Seorang pengawas bisa melakukan banyak verifikasi.
     */
    public function verifikasiRat(): HasMany
    {
        return $this->hasMany(VerifikasiRat::class, 'id_pengawas', 'id_pengawas');
    }
}