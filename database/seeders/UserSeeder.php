<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data internal (Admin, Pimpinan, Pengawas) dan Koperasi
        $users = [
            [
                'username' => 'admin_akurat',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
                'is_active'=> true,
            ],
            [
                'username' => 'pimpinan_utama',
                'email'    => 'pimpinan@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'pimpinan',
                'is_active'=> true,
            ],
            [
                'username' => 'pengawas_01',
                'email'    => 'pengawas@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'pengawas',
                'is_active'=> true,
            ],
            [
                'username' => 'koperasi_maju',
                'email'    => 'koperasi@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'koperasi',
                'is_active'=> true,
            ],
        ];

        // Looping untuk menyimpan data
        foreach ($users as $user) {
            User::create($user);
        }
    }
}