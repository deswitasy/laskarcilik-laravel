@props([
'headers' => [],
'data' => [],
'actions' => true,
'editRoute' => null,
'deleteRoute' => null,
'showRoute' => null
])

<div class="table-container">
    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                <th>{{ $header }}</th>
                @endforeach
                @if($actions)
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
            <tr>
                @foreach($row as $key => $value)
                @if($key !== 'id' && !str_starts_with($key, '_'))
                <td>{{ $value }}</td>
                @endif
                @endforeach

                @if($actions)
                <td>
                    <div class="action-buttons">
                        @if($showRoute)
                        <a href="{{ $showRoute($row) }}" class="btn btn-detail">
                            ⓘ Detail
                        </a>
                        @endif

                        @if($editRoute)
                        <a href="{{ $editRoute($row) }}" class="btn btn-edit">
                            ✏️ Edit
                        </a>
                        @endif

                        @if($deleteRoute)
                        <button
                            class="btn btn-delete"
                            data-url="{{ $deleteRoute($row) }}"
                            data-name="{{ $row['nama'] ?? $row['name'] ?? 'data ini' }}">
                            🗑️ Hapus
                        </button>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($headers) + ($actions ? 1 : 0) }}" style="text-align: center; padding: 30px; color: #999;">
                    Tidak ada data yang ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(method_exists($data, 'links'))
<div class="pagination">
    {{ $data->links() }}
</div>
@endif

@push('scripts')
<script>
    function confirmDelete(url, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus ${name}?`)) {
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