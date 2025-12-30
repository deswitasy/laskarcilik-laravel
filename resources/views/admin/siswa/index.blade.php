@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')
<!-- Controls -->
<div class="controls">
    <a href="{{ route('admin.siswa.create') }}" class="add-button">
        ➕ Tambah Siswa
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
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                <option value="keluar" {{ request('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>

            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="🔍 Cari nama siswa..."
                value="{{ request('search') }}">

            <button type="submit" class="filter-button">
                <span>🔍</span> Filter
            </button>

            @if(request()->hasAny(['search', 'kelas', 'status']))
            <a href="{{ route('admin.siswa.index') }}" class="clear-filter-button">
                Clear Filter
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
                        <a href="{{ route('admin.siswa.show', $s->id_siswa) }}" class="btn btn-detail">
                            ⓘ Detail
                        </a>
                        <a href="{{ route('admin.siswa.edit', $s->id_siswa) }}" class="btn btn-edit">
                            ✏️ Edit
                        </a>
                        <button
                            type="button"
                            class="btn btn-delete btn-delete-siswa"
                            data-url="{{ route('admin.siswa.destroy', $s->id_siswa) }}"
                            data-nama="{{ $s->nama_siswa }}"
                        >
                            🗑️ Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                    Tidak ada data siswa
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

@push('scripts')
<script>
// Event listener untuk tombol hapus siswa
document.querySelectorAll('.btn-delete-siswa').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        const url = this.getAttribute('data-url');
        const nama = this.getAttribute('data-nama');
        
        if (confirm(`Apakah Anda yakin ingin menghapus data siswa "${nama}"?`)) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Data berhasil dihapus!');
                    location.reload();
                } else {
                    alert('Gagal menghapus: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .badge {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
    }

    .badge-success {
        background: #28a745;
        color: white;
    }

    .badge-secondary {
        background: #6c757d;
        color: white;
    }
</style>
@endpush