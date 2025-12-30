@extends('layouts.guru')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')

@section('content')

<!-- ================= STATISTICS CARDS ================= -->
<div class="dashboard-cards">

    <div class="card">
        <div class="card-icon">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
        <div class="card-content">
            <h3>Total Catatan Saya</h3>
            <p class="card-number">
                {{ \App\Models\CatatanPerkembangan::where('id_user', Auth::id())->count() }}
            </p>
            <small class="card-change">Semua catatan yang dibuat</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fa-solid fa-user-graduate"></i>
        </div>
        <div class="card-content">
            <h3>Siswa Aktif</h3>
            <p class="card-number">
                {{ \App\Models\Siswa::where('status_siswa', 'aktif')->count() }}
            </p>
            <small class="card-change">Total siswa aktif</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fa-solid fa-pen-to-square"></i>
        </div>
        <div class="card-content">
            <h3>Catatan Bulan Ini</h3>
            <p class="card-number">
                {{ \App\Models\CatatanPerkembangan::where('id_user', Auth::id())
                    ->whereMonth('tanggal_catat', now()->month)
                    ->count() }}
            </p>
            <small class="card-change">{{ now()->format('F Y') }}</small>
        </div>
    </div>

</div>


<!-- ================= CHARTS ================= -->
<div class="charts-section">
    <div class="chart-container-large">
        <div class="chart-card">
            <h3>Catatan Mingguan</h3>
            <canvas id="chartCatatanMingguan"></canvas>
        </div>
    </div>

    <div class="chart-container-large">
        <div class="chart-card">
            <h3>Perkembangan Jumlah Siswa</h3>
            <canvas id="chartPerkembanganSiswa"></canvas>
        </div>
    </div>
</div>

<div class="charts-section">
    <div class="chart-container-small">
        <div class="chart-card">
            <h3>Distribusi Gender Siswa</h3>
            <canvas id="chartGenderSiswa"></canvas>
        </div>
    </div>

    <div class="chart-container-small">
        <div class="chart-card">
            <h3>Catatan per Aspek Penilaian</h3>
            <canvas id="chartKategori"></canvas>
        </div>
    </div>
</div>
<!-- Catatan Terbaru Saya -->
<div class="recent-section">
    <div class="section-header">
        <h2>Catatan Terbaru Saya</h2>
        <a href="{{ route('guru.catatan.create') }}" class="btn-add-small">
            ➕ Tambah Catatan
        </a>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Tahun Ajaran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\CatatanPerkembangan::with('siswa.kelas')->where('id_user', Auth::id())->latest()->take(5)->get() as $index => $catatan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $catatan->siswa->nama_siswa }}</td>
                    <td>{{ $catatan->siswa->kelas->nama_kelas }}</td>
                    <td>{{ $catatan->semester }}</td>
                    <td>{{ $catatan->tahun_ajaran }}</td>
                    <td>{{ \Carbon\Carbon::parse($catatan->tanggal_catat)->format('d-m-Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('guru.catatan.show', $catatan->id_catatan) }}" class="btn btn-detail">
                                ⓘ Detail
                            </a>
                            <a href="{{ route('guru.catatan.edit', $catatan->id_catatan) }}" class="btn btn-edit">
                                ✏️ Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                        Belum ada catatan. <a href="{{ route('guru.catatan.create') }}" style="color: #275CB4;">Buat catatan pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(\App\Models\CatatanPerkembangan::where('id_user', Auth::id())->count() > 5)
    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('guru.catatan.index') }}" class="btn-view-all">
            Lihat Semua Catatan →
        </a>
    </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <h2>Akses Cepat</h2>

    <div class="action-cards">
        <a href="{{ route('guru.catatan.create') }}" class="action-card">
            <div class="action-icon">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <h3>Buat Catatan Baru</h3>
            <p>Tambah catatan perkembangan siswa</p>
        </a>

        <a href="{{ route('guru.siswa.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <h3>Lihat Daftar Siswa</h3>
            <p>Lihat semua siswa aktif</p>
        </a>

        <a href="{{ route('guru.catatan.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <h3>Semua Catatan</h3>
            <p>Lihat semua catatan yang dibuat</p>
        </a>
    </div>
</div>

@endsection

{{-- ================= DATA DATABASE ================= --}}
@php
use Carbon\Carbon;

$catatanPerHari = \App\Models\CatatanPerkembangan::selectRaw("
        DAYOFWEEK(tanggal_catat) as hari,
        COUNT(*) as total
    ")
    ->where('id_user', Auth::id())
    ->groupBy('hari')
    ->pluck('total', 'hari')
    ->toArray();

/*
DAYOFWEEK:
1 = Minggu
2 = Senin
3 = Selasa
4 = Rabu
5 = Kamis
6 = Jumat
7 = Sabtu
*/

$catatanMingguan = [
    $catatanPerHari[2] ?? 0, // Senin
    $catatanPerHari[3] ?? 0, // Selasa
    $catatanPerHari[4] ?? 0, // Rabu
    $catatanPerHari[5] ?? 0, // Kamis
    $catatanPerHari[6] ?? 0, // Jumat
];


// Perkembangan siswa per tahun
$perkembanganSiswa = \App\Models\Siswa::selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
    ->groupBy('tahun')
    ->orderBy('tahun')
    ->get();

$labelTahun = $perkembanganSiswa->pluck('tahun');
$dataSiswa  = $perkembanganSiswa->pluck('total');

// Gender
$lakiLaki   = \App\Models\Siswa::where('jenis_kelamin', 'Laki-laki')->count();
$perempuan  = \App\Models\Siswa::where('jenis_kelamin', 'Perempuan')->count();

// Kategori
$kategori = [
    \App\Models\DetailCatatan::whereHas('catatanPerkembangan', fn($q) => $q->where('id_user', Auth::id()))->where('id_kategori', 1)->count(),
    \App\Models\DetailCatatan::whereHas('catatanPerkembangan', fn($q) => $q->where('id_user', Auth::id()))->where('id_kategori', 2)->count(),
    \App\Models\DetailCatatan::whereHas('catatanPerkembangan', fn($q) => $q->where('id_user', Auth::id()))->where('id_kategori', 3)->count(),
    \App\Models\DetailCatatan::whereHas('catatanPerkembangan', fn($q) => $q->where('id_user', Auth::id()))->where('id_kategori', 4)->count(),
];
@endphp

{{-- ================= SCRIPTS ================= --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const catatanMingguan = @json($catatanMingguan);
const labelTahun = @json($labelTahun);
const dataSiswa = @json($dataSiswa);
const genderData = [{{ $lakiLaki }}, {{ $perempuan }}];
const kategoriData = @json($kategori);

// Catatan Mingguan
new Chart(document.getElementById('chartCatatanMingguan'), {
    type: 'bar',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
        datasets: [{
            data: catatanMingguan,
            backgroundColor: '#36A2EB',
            borderRadius: 6
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});

// Perkembangan Siswa
new Chart(document.getElementById('chartPerkembanganSiswa'), {
    type: 'line',
    data: {
        labels: labelTahun,
        datasets: [{
            label: 'Jumlah Siswa',
            data: dataSiswa,
            borderColor: '#36A2EB',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                precision: 0,
                stepSize: 1
            }
        }
    }
}

});


// Gender
new Chart(document.getElementById('chartGenderSiswa'), {
    type: 'doughnut',
    data: {
        labels: ['Laki-laki', 'Perempuan'],
        datasets: [{ data: genderData, backgroundColor: ['#36A2EB', '#FF6384'] }]
    }
});

// Kategori
new Chart(document.getElementById('chartKategori'), {
    type: 'pie',
    data: {
        labels: ['Agama', 'Jati Diri', 'STEM', 'Pancasila'],
        datasets: [{ data: kategoriData }]
    }
});
</script>
@endpush
