@extends('layouts.guru')
@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/detail-catatan.css') }}">
@endpush
@section('content')
<div class="detail-card">
    <div class="detail-header">
        <div class="detail-header-info">
            <div class="detail-avatar">
                {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
            </div>
            <div>
                <h2>{{ $siswa->nama_siswa }}</h2>
                <p class="detail-header-sub">
                    Kelas {{ $siswa->kelas->nama_kelas }} &middot; {{ $siswa->jenis_kelamin }}
                </p>
            </div>
        </div>
        <div class="detail-actions">
            <a href="{{ route('guru.catatan.create', ['siswa' => $siswa->id_siswa]) }}" class="btn-detail-edit"
               style="background:rgba(6,214,160,.2); border-color:rgba(6,214,160,.4);">
                <i class="fa-solid fa-plus"></i> Buat Catatan
            </a>
            <a href="{{ route('guru.siswa.index') }}" class="btn-detail-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="detail-content">
        <div class="info-section">
            <h3>Informasi Siswa</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $siswa->nama_siswa }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kelas</span>
                    <span class="info-value">{{ $siswa->kelas->nama_kelas }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kelamin</span>
                    <span class="info-value">{{ $siswa->jenis_kelamin }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Usia</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }} tahun</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Riwayat Catatan Saya</h3>
            @if($siswa->catatanPerkembangan->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa->catatanPerkembangan as $index => $catatan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($catatan->tanggal_catat)->format('d-m-Y') }}</td>
                                <td>{{ $catatan->semester }}</td>
                                <td>{{ $catatan->tahun_ajaran }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button"
                                            class="btn btn-detail btn-open-preview"
                                            data-url="{{ route('guru.catatan.show', $catatan->id_catatan) }}"
                                            data-nama="{{ $catatan->siswa->nama_siswa }}"
                                            data-pdf="{{ route('guru.catatan.pdf', $catatan->id_catatan) }}">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state" style="padding: 28px; text-align: center; color: var(--text-light);">
                    <i class="fa-solid fa-clipboard" style="font-size:26px; display:block; margin-bottom:8px; opacity:.3;"></i>
                    Anda belum membuat catatan untuk siswa ini
                </div>
            @endif
        </div>
    </div>
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
})();
</script>

@endpush