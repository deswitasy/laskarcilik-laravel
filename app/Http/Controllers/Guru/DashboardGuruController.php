<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\CatatanPerkembangan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardGuruController extends Controller
{
    public function index()
    {
        $guruId = Auth::id();


$totalSiswa = Siswa::where('id_siswa', $guruId)->count();

$totalCatatan = CatatanPerkembangan::where('id_siswa', $guruId)->count();

$totalGuru = DB::table('users')->count();

        $catatanMingguan = CatatanPerkembangan::where('id_user', $guruId)
            ->whereBetween('tanggal_catat', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->select(DB::raw('DAYNAME(tanggal_catat) as hari'), DB::raw('COUNT(*) as total'))
            ->groupBy('hari')
            ->pluck('total', 'hari')
            ->toArray();

        // Format array Sen - Jum
        $hariMap = ['Monday'=>'Sen', 'Tuesday'=>'Sel', 'Wednesday'=>'Rab', 'Thursday'=>'Kam', 'Friday'=>'Jum'];
        $catatanChart = [];

        foreach ($hariMap as $eng => $indo) {
            $catatanChart[] = $catatanMingguan[$eng] ?? 0;
        }

        // Chart perkembangan jumlah siswa tiap tahun
        $chartLine = Siswa::select(
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->where('id_siswa', $guruId)
            ->groupBy('tahun')
            ->pluck('total', 'tahun')
            ->toArray();

        // Chart gender siswa
        $genderData = [
            'lakiLaki' => Siswa::where('id_siswa', $guruId)->where('jenis_kelamin', 'L')->count(),
            'perempuan' => Siswa::where('id_siswa', $guruId)->where('jenis_kelamin', 'P')->count(),
        ];

        return view('guru.dashboard', compact(
            'totalSiswa',
            'totalCatatan',
            'totalGuru',
            'catatanChart',
            'chartLine',
            'genderData'
        ));
    }
}
