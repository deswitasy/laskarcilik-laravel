<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'nama_user' => 'Admin Laskar Cilik',
            'username' => 'admin',
            'email' => 'admin@laskarcilik.com',
            'password' => Hash::make('admin123'),
            'hak_akses' => 'admin',
            'status' => 'aktif'
        ]);

        User::create([
            'nama_user' => 'Deswita',
            'username' => 'guru01',
            'email' => 'des@gmail.com',
            'password' => Hash::make('gurupass'),
            'no_hp' => '081234567890',
            'hak_akses' => 'guru',
            'status' => 'aktif'
        ]);

        User::create([
            'nama_user' => 'Rara',
            'username' => 'guru02',
            'email' => 'rara@gmail.com',
            'password' => Hash::make('gurupass2'),
            'no_hp' => '089876543210',
            'hak_akses' => 'guru',
            'status' => 'aktif'
        ]);
    }
}

