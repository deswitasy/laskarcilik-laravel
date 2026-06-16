@extends('layouts.guru')

@section('title', 'Daftar Siswa')
@section('page-title', 'Daftar Siswa')

@section('content')

<!-- Controls -->
<div class="controls">
    <div class="filter-section">
        <form method="GET" action="{{ route('guru.siswa.index') }}">

            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Cari nama siswa..."
                value="{{ request('search') }}"
            >

            <button type="submit" class="filter-button">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            @if(request('search'))
                <a href="{{ route('guru.siswa.index') }}" class="clear-filter-button">
                    <i class="fa-solid fa-xmark"></i>
                    Reset
                </a>
            @endif

        </form>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>Usia</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($siswa as $index => $s)
            <tr>

                <td>
                    {{ $siswa->firstItem() + $index }}
                </td>

                <td>
                    {{ $s->nama_siswa }}
                </td>

                <td>
                    {{ $s->kelas->nama_kelas ?? '-' }}
                </td>

                <td>
                    {{ $s->jenis_kelamin }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($s->tanggal_lahir)->age }} tahun
                </td>

                <td>
                    <div class="action-buttons">

                        <!-- Detail -->
                        <a href="{{ route('guru.siswa.show', $s->id_siswa) }}"
                           class="btn-detail"
                           title="Lihat Detail">
                            <i class="fa-solid fa-eye"></i>
                            Detail
                        </a>

                        <!-- Tambah Catatan -->
                        <a href="{{ route('guru.catatan.create', ['siswa' => $s->id_siswa]) }}"
                           class="btn-add-text">
                            <i class="fa-solid fa-plus"></i>
                            Catatan
                        </a>

                    </div>
                </td>

            </tr>

            @empty
            <tr>
                <td colspan="6" class="empty-state">

                    <i class="fa-solid fa-users"
                       style="font-size:24px; display:block; margin-bottom:8px; opacity:.4;">
                    </i>

                    Tidak ada data siswa aktif

                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top:18px; display:flex; flex-direction:column; align-items:center; gap:6px;">

    {{ $siswa->links('vendor.pagination.custom') }}

    <small style="color:#9BA3C8; font-size:12px; font-weight:600;">
        Menampilkan
        {{ $siswa->firstItem() }}
        –
        {{ $siswa->lastItem() }}
        dari
        {{ $siswa->total() }}
        data
    </small>

</div>

@endsection

@push('styles')
<style>

.action-buttons{
    display:flex;
    align-items:center;
    gap:8px;
}

/* DETAIL BUTTON */
.btn-detail{
   
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:12px;
    gap:6px;

    background:#f3f1ff;
    color:#6c63ff;
    text-decoration:none;
    transition:.2s ease;
}

.btn-detail:hover{
    background:#e7e3ff;
    color:#5b52f5;
    transform:translateY(-1px);
}

/* CATATAN BUTTON */
.btn-add-text{
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    padding:0 14px;

    border-radius:12px;

    background:#f0fdf4;
    color:#22c55e;

    text-decoration:none;
    font-size:13px;
    font-weight:600;

    transition:.2s ease;

    border:1px solid #dcfce7;
}

.btn-add-text:hover{
    background:#dcfce7;
    color:#16a34a;
    transform:translateY(-1px);
}

</style>
@endpush