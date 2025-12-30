<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\CatatanPerkembangan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalGuru' => User::where('hak_akses', 'guru')->count(),
            'totalSiswa' => Siswa::count(),
            'totalCatatan' => CatatanPerkembangan::count(),

            'genderData' => [
                'lakiLaki' => Siswa::where('jenis_kelamin', 'Laki-laki')->count(),
                'perempuan' => Siswa::where('jenis_kelamin', 'Perempuan')->count(),
            ],

            'kelasData' => Siswa::select('id_kelas', DB::raw('count(*) as total'))
                ->groupBy('id_kelas')
                ->with('kelas')
                ->get()
                ->map(fn ($row) => [
                    'kelas' => $row->kelas->nama_kelas ?? 'Unknown',
                    'total' => $row->total
                ]),
        ]);
    }
}
