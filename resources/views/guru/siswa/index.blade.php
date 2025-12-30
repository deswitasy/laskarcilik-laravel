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
                placeholder="🔍 Cari nama siswa..." 
                value="{{ request('search') }}"
            >
            <button type="submit" class="filter-button">
                <span>🔍</span> Cari
            </button>
            
            @if(request('search'))
                <a href="{{ route('guru.siswa.index') }}" class="clear-filter-button">
                    Clear
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
                <td>{{ $siswa->firstItem() + $index }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->kelas->nama_kelas }}</td>
                <td>{{ $s->jenis_kelamin }}</td>
                <td>{{ \Carbon\Carbon::parse($s->tanggal_lahir)->age }} tahun</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('guru.siswa.show', $s->id_siswa) }}" class="btn btn-detail">
                            ⓘ Detail
                        </a>
                        <a href="{{ route('guru.catatan.create', ['siswa' => $s->id_siswa]) }}" class="btn btn-add">
                            ➕ Buat Catatan
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #999;">
                    Tidak ada data siswa aktif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination">
    {{ $siswa->links() }}
</div>
@endsection

@push('styles')
<style>
.btn-add {
    background: #28a745;
    color: white;
}
.btn-add:hover {
    background: #218838;
}
</style>
@endpush