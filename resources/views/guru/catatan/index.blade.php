@extends('layouts.guru')

@section('title', 'Daftar Catatan')
@section('page-title', 'Daftar Catatan Perkembangan')

@section('content')
<!-- Controls -->
<div class="controls">
    <a href="{{ route('guru.catatan.create') }}" class="add-button">
        ➕ Tambah Catatan
    </a>

    <div class="filter-section">
        <form method="GET" action="{{ route('guru.catatan.index') }}">
            <input 
                type="date" 
                name="start_date" 
                class="date-input" 
                value="{{ request('start_date') }}"
            >
            <span>-</span>
            <input 
                type="date" 
                name="end_date" 
                class="date-input" 
                value="{{ request('end_date') }}"
            >
            <button type="submit" class="filter-button">
                <span>🔍</span> Filter
            </button>
            
            @if(request()->hasAny(['search', 'start_date', 'end_date']))
                <a href="{{ route('guru.catatan.index') }}" class="clear-filter-button">
                    Clear Filter
                </a>
            @endif

            <input 
                type="text" 
                name="search" 
                class="search-input" 
                placeholder="🔍 Cari nama siswa..." 
                value="{{ request('search') }}"
            >
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
                <th>Semester</th>
                <th>Tahun Ajaran</th>
                <th>Tanggal Pencatatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($catatan as $index => $c)
            <tr>
                <td>{{ $catatan->firstItem() + $index }}</td>
                <td>{{ $c->siswa->nama_siswa }}</td>
                <td>{{ $c->siswa->kelas->nama_kelas }}</td>
                <td>{{ $c->semester }}</td>
                <td>{{ $c->tahun_ajaran }}</td>
                <td>{{ \Carbon\Carbon::parse($c->tanggal_catat)->format('d-m-Y') }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('guru.catatan.show', $c->id_catatan) }}" class="btn btn-detail">
                            ⓘ Detail
                        </a>
                        <a href="{{ route('guru.catatan.edit', $c->id_catatan) }}" class="btn btn-edit">
                            ✏️ Edit
                        </a>
                        <button 
                            type="button"
                            class="btn btn-delete btn-delete-catatan"
                            data-url="{{ route('guru.catatan.destroy', $c->id_catatan) }}"
                            data-nama="{{ $c->siswa->nama_siswa }}">
                            🗑️ Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                    Belum ada catatan yang dibuat
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination">
    {{ $catatan->links() }}
</div>
@endsection

@push('scripts')
<script>
// Event listener untuk tombol hapus catatan
document.querySelectorAll('.btn-delete-catatan').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        const url = this.getAttribute('data-url');
        const nama = this.getAttribute('data-nama');
        
        if (confirm(`Apakah Anda yakin ingin menghapus catatan untuk "${nama}"?`)) {
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
                    alert(data.message || 'Catatan berhasil dihapus!');
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