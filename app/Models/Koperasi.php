<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Koperasi extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'koperasi';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_koperasi';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_user',
        'nama_koperasi',
        'no_badan_hukum',
        'alamat',
        'kecamatan',
        'tgl_berdiri',
        'status_koperasi',
        'jumlah_anggota',
        'ketua',
        'sekretaris',
        'bendahara',
    ];

    /**
     * Relasi ke model User.
     * Koperasi dimiliki oleh satu User (Akun login).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model Rat.
     * Satu Koperasi bisa memiliki banyak kegiatan RAT.
     */
    public function rat(): HasMany
    {
        return $this->hasMany(Rat::class, 'id_koperasi', 'id_koperasi');
    }
}