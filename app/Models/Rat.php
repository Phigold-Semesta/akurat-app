<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rat extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'rat';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_rat';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_koperasi',
        'id_pimpinan',
        'tahun_buku',
        'tgl_rat',
        'tempat_rat',
        'jumlah_peserta',
        'file_dokumen',
        'hasil_rat',
    ];

    /**
     * Relasi ke model Koperasi.
     * RAT milik satu Koperasi.
     */
    public function koperasi(): BelongsTo
    {
        return $this->belongsTo(Koperasi::class, 'id_koperasi', 'id_koperasi');
    }

    /**
     * Relasi ke model Pimpinan.
     * RAT bisa ditinjau oleh satu Pimpinan.
     */
    public function pimpinan(): BelongsTo
    {
        return $this->belongsTo(Pimpinan::class, 'id_pimpinan', 'id_pimpinan');
    }

    /**
     * Relasi ke model DokumenRat.
     * Satu RAT memiliki banyak dokumen pendukung.
     */
    public function dokumenRat(): HasMany
    {
        return $this->hasMany(DokumenRat::class, 'id_rat', 'id_rat');
    }

    /**
     * Relasi ke model Laporan.
     * Satu RAT memiliki satu Laporan hasil.
     */
    public function laporan(): HasOne
    {
        return $this->hasOne(Laporan::class, 'id_rat', 'id_rat');
    }

    /**
     * Relasi ke model Pemkes.
     * Satu RAT memiliki satu Penilaian Kesehatan (Pemkes).
     */
    public function pemkes(): HasOne
    {
        return $this->hasOne(Pemkes::class, 'id_rat', 'id_rat');
    }

    /**
     * Relasi ke model Sertifikat.
     * Satu RAT dapat menghasilkan satu Sertifikat.
     */
    public function sertifikat(): HasOne
    {
        return $this->hasOne(Sertifikat::class, 'id_rat', 'id_rat');
    }
}