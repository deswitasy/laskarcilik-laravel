@extends('layouts.admin')
@section('title', 'Akun Guru')
@section('page-title', 'Kelola Akun Guru')

@section('content')
<div class="controls">
    <a href="{{ route('admin.guru.create') }}" class="add-button">
        <i class="fa-solid fa-plus"></i> Tambah Guru
    </a>

    <div class="filter-section">
        <form method="GET" action="{{ route('admin.guru.index') }}">
            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <input type="text" name="search" class="search-input"
                placeholder="Cari nama / username / email..." value="{{ request('search') }}">

            <button type="submit" class="filter-button">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>

            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.guru.index') }}" class="clear-filter-button">
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
                        <a href="{{ route('admin.guru.show', $g->id_user) }}"
                           class="btn-detail" title="Lihat Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.guru.edit', $g->id_user) }}"
                           class="btn-edit" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-state">
                    <i class="fa-solid fa-inbox" style="font-size:24px; display:block; margin-bottom:8px; opacity:.4;"></i>
                    Tidak ada data guru
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:18px; display:flex; justify-content:center;">
    {{ $guru->links() }}
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(url, nama) {
    if (confirm(`Hapus akun guru "${nama}"?`)) {
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { location.reload(); }
            else { alert('Gagal: ' + data.message); }
        })
        .catch(err => alert('Terjadi kesalahan: ' + err));
    }
}
</script>
@endpush