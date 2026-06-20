<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiRat extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'verifikasi_rat';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_verifikasi';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_rat',
        'id_pengawas',
        'tgl_verifikasi',
        'status_validasi',
        'rekomendasi',
        'file_ba_verifikasi',
    ];

    /**
     * Relasi ke model Rat.
     * Verifikasi ini milik satu kegiatan RAT.
     */
    public function rat(): BelongsTo
    {
        return $this->belongsTo(Rat::class, 'id_rat', 'id_rat');
    }

    /**
     * Relasi ke model PengawasLapangan.
     * Verifikasi ini dilakukan oleh satu pengawas.
     */
    public function pengawas(): BelongsTo
    {
        return $this->belongsTo(PengawasLapangan::class, 'id_pengawas', 'id_pengawas');
    }
}