<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemkes extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'pemkes';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_pemkes';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_rat',
        'skor_pemkes',
        'skor_jpfk',
        'status_kesehatan',
        'catatan_jpfk',
        'tahun_penilaian',
    ];

    /**
     * Relasi ke model Rat.
     * Penilaian kesehatan (Pemkes) dilakukan berdasarkan hasil dari satu RAT.
     */
    public function rat(): BelongsTo
    {
        return $this->belongsTo(Rat::class, 'id_rat', 'id_rat');
    }
}