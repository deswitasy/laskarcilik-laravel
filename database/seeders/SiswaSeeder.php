<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        Siswa::create([
            'id_kelas' => 1,
            'nama_siswa' => 'Deswita Syaharani',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2018-05-10',
            'tempat_lahir' => 'Bandung',
            'status_siswa' => 'aktif'
        ]);

        Siswa::create([
            'id_kelas' => 1,
            'nama_siswa' => 'Ahmad Fauzi',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2018-03-15',
            'tempat_lahir' => 'Solo',
            'status_siswa' => 'aktif'
        ]);
    }
}
