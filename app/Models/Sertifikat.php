<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'sertifikat';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_sertifikat';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_rat',
        'nomor_sertifikat',
        'tgl_terbit',
        'file_sertifikat',
        'qr_code_path',
    ];

    /**
     * Relasi ke model Rat.
     * Sertifikat diterbitkan berdasarkan hasil dari satu RAT.
     */
    public function rat(): BelongsTo
    {
        return $this->belongsTo(Rat::class, 'id_rat', 'id_rat');
    }
}