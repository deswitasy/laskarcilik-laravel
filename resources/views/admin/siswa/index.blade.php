@extends('layouts.admin')
@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')
<div class="controls">
    <a href="{{ route('admin.siswa.create') }}" class="add-button">
        <i class="fa-solid fa-plus"></i> Tambah Siswa
    </a>

    <div class="filter-section">
        <form method="GET" action="{{ route('admin.siswa.index') }}">
            <select name="kelas" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id_kelas }}" {{ request('kelas') == $k->id_kelas ? 'selected' : '' }}>
                    Kelas {{ $k->nama_kelas }}
                </option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif"   {{ request('status') == 'aktif'   ? 'selected' : '' }}>Aktif</option>
                <option value="lulus"   {{ request('status') == 'lulus'   ? 'selected' : '' }}>Lulus</option>
                <option value="pindah"  {{ request('status') == 'pindah'  ? 'selected' : '' }}>Pindah</option>
                <option value="keluar"  {{ request('status') == 'keluar'  ? 'selected' : '' }}>Keluar</option>
            </select>

            <input type="text" name="search" class="search-input"
                placeholder="Cari nama siswa..." value="{{ request('search') }}">

            <button type="submit" class="filter-button">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>

            @if(request()->hasAny(['search', 'kelas', 'status']))
            <a href="{{ route('admin.siswa.index') }}" class="clear-filter-button">
                <i class="fa-solid fa-xmark"></i> Reset
            </a>
            @endif
        </form>
    </div>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Status</th>
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
                <td>{{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d-m-Y') }}</td>
                <td>
                    <span class="badge badge-{{ $s->status_siswa === 'aktif' ? 'success' : 'secondary' }}">
                        {{ ucfirst($s->status_siswa) }}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.siswa.show', $s->id_siswa) }}"
                           class="btn-detail" title="Lihat Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.siswa.edit', $s->id_siswa) }}"
                           class="btn-edit" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button type="button"
                            class="btn-delete btn-delete-siswa"
                            data-url="{{ route('admin.siswa.destroy', $s->id_siswa) }}"
                            data-nama="{{ $s->nama_siswa }}"
                            title="Hapus">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-state">
                    <i class="fa-solid fa-inbox" style="font-size:24px; display:block; margin-bottom:8px; opacity:.4;"></i>
                    Tidak ada data siswa
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:18px; display:flex; flex-direction:column; align-items:center; gap:6px;">
    {{ $siswa->links('vendor.pagination.custom') }}
    <small style="color:#9BA3C8; font-size:12px; font-weight:600;">
        Menampilkan {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari {{ $siswa->total() }} data
    </small>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-delete-siswa').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const url  = this.getAttribute('data-url');
        const nama = this.getAttribute('data-nama');
        if (confirm(`Hapus data siswa "${nama}"?`)) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) { location.reload(); }
                else { alert('Gagal menghapus: ' + (data.message || '')); }
            })
            .catch(err => alert('Terjadi kesalahan: ' + err.message));
        }
    });
});
</script>
@endpush
