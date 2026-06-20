<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Menentukan tabel yang digunakan.
     */
    protected $table = 'user';

    /**
     * Menentukan primary key.
     */
    protected $primaryKey = 'id_user';

    /**
     * Menentukan atribut yang dapat diisi (Fillable).
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * Menentukan atribut yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }
}