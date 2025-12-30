@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')

<!-- STATISTIC CARDS -->
<div class="dashboard-cards">

    <div class="card">
        <div class="card-icon">
            <i class="fa-solid fa-chalkboard-user"></i>
        </div>
        <div class="card-content">
            <h3>Total Guru</h3>
            <p class="card-number">
                {{ \App\Models\User::where('hak_akses', 'guru')->count() }}
            </p>
            <small class="card-change">Data saat ini</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fa-solid fa-user-graduate"></i>
        </div>
        <div class="card-content">
            <h3>Total Siswa</h3>
            <p class="card-number">
                {{ \App\Models\Siswa::count() }}
            </p>
            <small class="card-change">Seluruh siswa terdaftar</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon">
            <i class="fa-solid fa-school"></i>
        </div>
        <div class="card-content">
            <h3>Total Kelas</h3>
            <p class="card-number">
                {{ \App\Models\Kelas::count() }}
            </p>
            <small class="card-change">Kelas aktif</small>
        </div>
    </div>

</div>


<!-- CHART SISWA -->
<div class="charts-section">

    <div class="chart-container-large">
        <div class="chart-card">
            <h3>Perkembangan Jumlah Siswa</h3>
            <canvas id="chartPerkembanganSiswa"></canvas>
        </div>
    </div>

    <div class="chart-container-large">
        <div class="chart-card">
            <h3>Distribusi Siswa per Kelas</h3>
            <canvas id="chartDistribusiKelas"></canvas>
        </div>
    </div>

</div>

<!-- GENDER + STATUS SISWA -->
<div class="charts-section">

    <div class="chart-container-small">
        <div class="chart-card">
            <h3>Distribusi Gender</h3>
            <canvas id="chartGender"></canvas>
        </div>
    </div>

    <div class="chart-container-small">
        <div class="chart-card">
            <h3>Status Siswa</h3>
            <canvas id="chartStatus"></canvas>
        </div>
    </div>

</div>

<!-- GURU CHART (BARU) -->
<div class="charts-section">

    <div class="chart-container-large">
        <div class="chart-card">
            <h3>Perkembangan Jumlah Guru</h3>
            <canvas id="chartPerkembanganGuru"></canvas>
        </div>
    </div>

    <div class="chart-container-small">
        <div class="chart-card">
            <h3>Status Akun Guru</h3>
            <canvas id="chartStatusGuru"></canvas>
        </div>
    </div>

</div>

<!-- TABEL SISWA TERBARU -->
<div class="recent-section">
    <h2>Data Siswa Terbaru</h2>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Gender</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Siswa::with('kelas')->latest()->take(5)->get() as $i => $siswa)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $siswa->nama_siswa }}</td>
                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $siswa->jenis_kelamin }}</td>
                    <td>
                        @php
                        $badgeClass = match($siswa->status_siswa) {
                        'Aktif' => 'success',
                        'Lulus' => 'primary',
                        'Pindah' => 'warning',
                        'Keluar' => 'danger',
                        default => 'secondary',
                        };
                        @endphp

                        <span class="badge {{ $badgeClass }}">
                            {{ $siswa->status_siswa }}
                        </span>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Quick Actions -->
<div class="quick-actions">
    <h2>Akses Cepat</h2>

    <div class="action-cards">
        <a href="{{ route('admin.siswa.create') }}" class="action-card">
            <div class="action-icon">
                <i class="fa-solid fa-file-circle-plus"></i>
            </div>
            <h3>Buat Data Baru</h3>
            <p>Tambah Data siswa</p>
        </a>

        <a href="{{ route('admin.siswa.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <h3>Lihat Data Siswa</h3>
            <p>Lihat semua data siswa</p>
        </a>
        <a href="{{ route('admin.guru.create') }}" class="action-card">
            <div class="action-icon">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h3>Buat Data Baru</h3>
            <p>Tambah Akun Guru</p>
        </a>
        <a href="{{ route('admin.guru.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <h3>Lihat Akun Guru</h3>
            <p>Lihat Data akun Guru</p>
        </a>
    </div>
</div>
@endsection

{{-- DATA DATABASE --}}
@php
// siswa per tahun
$perkembangan = \App\Models\Siswa::selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
->groupBy('tahun')->orderBy('tahun')->get();

$labelTahun = $perkembangan->pluck('tahun');
$dataSiswa = $perkembangan->pluck('total');

// kelas
$kelas = \App\Models\Kelas::withCount('siswa')->get();
$labelKelas = $kelas->pluck('nama_kelas');
$dataKelas = $kelas->pluck('siswa_count');

// gender
$gender = [
\App\Models\Siswa::where('jenis_kelamin','Laki-laki')->count(),
\App\Models\Siswa::where('jenis_kelamin','Perempuan')->count()
];

// siswa
$status = [
\App\Models\Siswa::where('status_siswa','Aktif')->count(),
\App\Models\Siswa::where('status_siswa','Lulus')->count(),
\App\Models\Siswa::where('status_siswa','Pindah')->count(),
\App\Models\Siswa::where('status_siswa','Keluar')->count(),
];


// guru
$perkembanganGuru = \App\Models\User::where('hak_akses','guru')
->selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
->groupBy('tahun')->orderBy('tahun')->get();

$labelTahunGuru = $perkembanganGuru->pluck('tahun');
$dataGuru = $perkembanganGuru->pluck('total');

$statusGuru = [
\App\Models\User::where('hak_akses','guru')->where('status','aktif')->count(),
\App\Models\User::where('hak_akses','guru')->where('status','nonaktif')->count(),
];
@endphp

@push('scripts')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    //    DATA SISWA

    window.chartPerkembanganSiswaData = {
        labels: @json($labelTahun),
        datasets: [{
            label: 'Jumlah Siswa',
            data: @json($dataSiswa),
            fill: true,
            tension: 0.4
        }]
    };

    window.chartDistribusiKelasData = {
        labels: @json($labelKelas),
        datasets: [{
            data: @json($dataKelas)
        }]
    };

    window.chartGenderData = {
        labels: ['Laki-laki', 'Perempuan'],
        datasets: [{
            data: @json($gender)
        }]
    };

    window.chartStatusSiswaData = {
        labels: ['Aktif', 'Lulus', 'Pindah', 'Keluar'],
        datasets: [{
            data: @json($status)
        }]
    };

    //   DATA GURU
    window.chartPerkembanganGuruData = {
        labels: @json($labelTahunGuru),
        datasets: [{
            label: 'Jumlah Guru',
            data: @json($dataGuru),
            fill: true,
            tension: 0.4
        }]
    };

    window.chartStatusGuruData = {
        labels: ['Aktif', 'Nonaktif'],
        datasets: [{
            data: @json($statusGuru)
        }]
    };
</script>

<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush