@extends('layouts.guru')
@section('title', 'Daftar Catatan')
@section('page-title', 'Daftar Catatan Perkembangan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detail-catatan.css') }}">
@endpush

@section('content')
<div class="controls">
    <a href="{{ route('guru.catatan.create') }}" class="add-button">
        <i class="fa-solid fa-plus"></i> Tambah Catatan
    </a>
    <div class="filter-section">
        <form method="GET" action="{{ route('guru.catatan.index') }}">
            <input type="date" name="start_date" class="date-input" value="{{ request('start_date') }}">
            <span style="color:var(--text-light);font-size:13px;">—</span>
            <input type="date" name="end_date" class="date-input" value="{{ request('end_date') }}">
            <input type="text" name="search" class="search-input"
                placeholder="Cari nama siswa..." value="{{ request('search') }}">
            <button type="submit" class="filter-button">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>
            @if(request()->hasAny(['search','start_date','end_date']))
                <a href="{{ route('guru.catatan.index') }}" class="clear-filter-button">
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
                        <button type="button"
                            class="btn-detail btn-open-preview"
                            data-url="{{ route('guru.catatan.show', $c->id_catatan) }}"
                            data-nama="{{ $c->siswa->nama_siswa }}"
                            data-pdf="{{ route('guru.catatan.pdf', $c->id_catatan) }}">
                            <i class="fa-solid fa-eye"></i> Detail
                        </button>
                        <a href="{{ route('guru.catatan.edit', $c->id_catatan) }}" class="btn-edit">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <button type="button"
                            class="btn-delete btn-delete-catatan"
                            data-url="{{ route('guru.catatan.destroy', $c->id_catatan) }}"
                            data-nama="{{ $c->siswa->nama_siswa }}">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-state">
                    <i class="fa-solid fa-clipboard"
                       style="font-size:24px;display:block;margin-bottom:8px;opacity:.3;"></i>
                    Belum ada catatan yang dibuat
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $catatan->links('vendor.pagination.custom') }}
</div>
@endsection

@push('scripts')
<script>
(function () {
    const existing = document.getElementById('docOverlay');
    if (existing) existing.remove();
    const existingZoom = document.getElementById('fotoZoomOverlay');
    if (existingZoom) existingZoom.remove();

    document.body.insertAdjacentHTML('beforeend', `
        <div id="docOverlay">
            <div id="docBackdrop"></div>
            <div id="docModal">
                <div id="docToolbar">
                    <button id="docBtnClose">
                        <i class="fa-solid fa-xmark"></i> Tutup
                    </button>
                    <span id="docModalNama">
                        <i class="fa-solid fa-file-lines"></i>
                        Pratinjau Dokumen
                    </span>
                    <a id="docBtnPrint" href="#">
                        <i class="fa-solid fa-download"></i> Unduh PDF
                    </a>
                </div>
                <div id="docScrollArea">
                    <div id="docLoading">
                        <div id="docSpinner"></div>
                        <p>Memuat dokumen...</p>
                    </div>
                    <div id="docPaperWrap">
                        <div id="docPaper"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="fotoZoomOverlay">
            <img id="fotoZoomImg" src="" alt="">
        </div>
    `);

    document.getElementById('docPaperWrap').style.display = 'none';

    const overlay    = document.getElementById('docOverlay');
    const modal      = document.getElementById('docModal');
    const backdrop   = document.getElementById('docBackdrop');
    const paper      = document.getElementById('docPaper');
    const paperWrap  = document.getElementById('docPaperWrap');
    const loading    = document.getElementById('docLoading');
    const btnClose   = document.getElementById('docBtnClose');
    const btnPrint   = document.getElementById('docBtnPrint');
    const namaLabel  = document.getElementById('docModalNama');
    const scrollArea = document.getElementById('docScrollArea');
    const zoomBox    = document.getElementById('fotoZoomOverlay');
    const zoomImg    = document.getElementById('fotoZoomImg');

    // Tombol unduh PDF — langsung download via route cetakPDF (Dompdf)
    // href sudah di-set saat buka preview, cukup biarkan anchor bekerja normal
    // Tidak perlu override apapun di sini

    document.querySelectorAll('.btn-open-preview').forEach(btn => {
        btn.addEventListener('click', function () {
            const url    = this.dataset.url;
            const nama   = this.dataset.nama || 'Pratinjau Dokumen';
            const pdfUrl = this.dataset.pdf || '#';

            paper.innerHTML         = '';
            paperWrap.style.display = 'none';
            loading.style.display   = 'flex';
            scrollArea.scrollTop    = 0;
            namaLabel.innerHTML     = `<i class="fa-solid fa-file-lines"></i> ${nama}`;

            // Set href tombol PDF ke route download Dompdf
            btnPrint.setAttribute('href', pdfUrl);

            overlay.style.display        = 'flex';
            document.body.style.overflow = 'hidden';

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    modal.style.transform = 'scale(1) translateY(0)';
                    modal.style.opacity   = '1';
                });
            });

            fetch(url + '?_fragment=1', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc    = parser.parseFromString(html, 'text/html');
                const konten = doc.querySelector('.paper-doc-content');

                paper.innerHTML = '';
                paper.appendChild(konten ? konten.cloneNode(true) : (() => {
                    const d = document.createElement('div');
                    d.innerHTML = html;
                    return d;
                })());

                loading.style.display   = 'none';
                paperWrap.style.display = 'block';

                paper.querySelectorAll('.foto-item img').forEach(img => {
                    img.addEventListener('click', function () {
                        zoomImg.src           = this.src;
                        zoomBox.style.display = 'flex';
                    });
                });
            })
            .catch(err => {
                loading.style.display   = 'none';
                paper.innerHTML         = `
                    <div class="doc-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Gagal memuat dokumen.<br>
                        <small>${err.message}</small>
                    </div>`;
                paperWrap.style.display = 'block';
                console.error('Doc preview error:', err);
            });
        });
    });

    function tutup() {
        modal.style.transform = 'scale(0.96) translateY(12px)';
        modal.style.opacity   = '0';
        setTimeout(() => {
            overlay.style.display        = 'none';
            document.body.style.overflow = '';
            paper.innerHTML              = '';
            paperWrap.style.display      = 'none';
            loading.style.display        = 'flex';
        }, 280);
    }

    btnClose.addEventListener('click', tutup);
    backdrop.addEventListener('click', tutup);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            if (zoomBox.style.display === 'flex') {
                zoomBox.style.display = 'none';
                zoomImg.src           = '';
            } else if (overlay.style.display === 'flex') {
                tutup();
            }
        }
    });

    zoomBox.addEventListener('click', function () {
        this.style.display = 'none';
        zoomImg.src        = '';
    });

    document.querySelectorAll('.btn-delete-catatan').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const url  = this.dataset.url;
            const nama = this.dataset.nama;
            if (confirm(`Apakah Anda yakin ingin menghapus catatan untuk "${nama}"?`)) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept':       'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) location.reload();
                    else alert('Gagal menghapus: ' + (data.message || ''));
                })
                .catch(err => alert('Terjadi kesalahan: ' + err.message));
            }
        });
    });

})();
</script>
@endpush