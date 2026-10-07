<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        User::truncate();

        $users = [
            [
                'nama_lengkap' => 'admin',
                'nis' => 'admin123',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'nama_lengkap' => 'guru biasa',
                'nis' => 'GURU001',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
            ],
            [
                'nama_lengkap' => 'kepala sekolah',
                'nis' => 'kepsek111',
                'password' => Hash::make('kepsek098'),
                'role' => 'kepsek',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

    }
}