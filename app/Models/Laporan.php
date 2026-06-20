<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'laporan';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_laporan';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'id_rat',
        'id_pimpinan',
        'tgl_laporan',
        'jenis_laporan',
        'status_laporan',
        'catatan_revisi',
    ];

    /**
     * Relasi ke model Rat.
     * Setiap Laporan dimiliki oleh satu kegiatan RAT.
     */
    public function rat(): BelongsTo
    {
        return $this->belongsTo(Rat::class, 'id_rat', 'id_rat');
    }

    /**
     * Relasi ke model Pimpinan.
     * Laporan ini mungkin ditinjau oleh seorang Pimpinan.
     */
    public function pimpinan(): BelongsTo
    {
        return $this->belongsTo(Pimpinan::class, 'id_pimpinan', 'id_pimpinan');
    }
}