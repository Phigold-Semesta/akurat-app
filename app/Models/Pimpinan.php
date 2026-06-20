<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pimpinan extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'pimpinan';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_pimpinan';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_user',
        'nama_pimpinan',
        'jabatan',
        'no_telp',
    ];

    /**
     * Relasi ke model User.
     * Pimpinan memiliki akun login (User).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model Laporan.
     * Seorang pimpinan dapat meninjau banyak laporan.
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_pimpinan', 'id_pimpinan');
    }
    
    /**
     * Relasi ke model Rat.
     * Seorang pimpinan dapat meninjau banyak RAT.
     */
    public function rat(): HasMany
    {
        return $this->hasMany(Rat::class, 'id_pimpinan', 'id_pimpinan');
    }
}