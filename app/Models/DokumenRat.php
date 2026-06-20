<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenRat extends Model
{
    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'dokumen_rat';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_dokumen';

    /**
     * Menentukan bahwa primary key tidak auto-increment jika perlu, 
     * atau biarkan default jika menggunakan BIGINT AUTO_INCREMENT.
     */
    public $incrementing = true;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_rat',
        'nama_dokumen',
        'file_path',
        'tgl_upload',
    ];

    /**
     * Relasi ke model Rat.
     * Satu DokumenRat milik satu Rat.
     */
    public function rat(): BelongsTo
    {
        return $this->belongsTo(Rat::class, 'id_rat', 'id_rat');
    }
}