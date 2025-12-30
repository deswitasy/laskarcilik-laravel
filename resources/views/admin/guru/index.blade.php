@extends('layouts.admin')

@section('title', 'Akun Guru')
@section('page-title', 'Kelola Akun Guru')

@section('content')
<!-- Controls -->
<div class="controls">
    <a href="{{ route('admin.guru.create') }}" class="add-button">
        ➕ Tambah Guru
    </a>

    <div class="filter-section">
        <form method="GET" action="{{ route('admin.guru.index') }}">
            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="🔍 Cari nama/username/email..."
                value="{{ request('search') }}">

            <button type="submit" class="filter-button">
                <span>🔍</span> Filter
            </button>

            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.guru.index') }}" class="clear-filter-button">
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
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guru as $index => $g)
            <tr>
                <td>{{ $guru->firstItem() + $index }}</td>
                <td>{{ $g->nama_user }}</td>
                <td>{{ $g->username }}</td>
                <td>{{ $g->email }}</td>
                <td>{{ $g->no_hp ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $g->status === 'aktif' ? 'success' : 'secondary' }}">
                        {{ ucfirst($g->status) }}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.guru.show', $g->id_user) }}" class="btn btn-detail">
                            ⓘ Detail
                        </a>
                        <a href="{{ route('admin.guru.edit', $g->id_user) }}" class="btn btn-edit">
                            ✏️ Edit
                        </a>
                        <!-- <button
                            type="button"
                            class="btn btn-delete btn-delete-siswa"
                            data-url="{{ route('admin.guru.destroy', $g) }}"

                            data-nama="{{ $g->nama_user }}">
                            🗑️ Hapus
                        </button> -->
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                    Tidak ada data guru
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination">
    {{ $guru->links() }}
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(url, nama) {
        if (confirm(`Apakah Anda yakin ingin menghapus akun guru "${nama}"?`)) {
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Gagal menghapus: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan: ' + error);
                });
        }
    }
</script>
@endpush