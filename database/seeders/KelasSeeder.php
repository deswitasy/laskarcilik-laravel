<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        Kelas::create(['nama_kelas' => 'A', 'tahun_ajaran' => 2025]);
        Kelas::create(['nama_kelas' => 'B', 'tahun_ajaran' => 2025]);
    }
}
