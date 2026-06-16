@extends('layouts.guru')

@section('title', 'Edit Catatan')
@section('page-title', 'Edit Catatan Perkembangan Siswa')

@section('content')
<form action="{{ route('guru.catatan.update', $catatan->id_catatan) }}" method="POST" class="form-container" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="id_siswa">Nama Lengkap <span class="required">*</span></label>
        <select id="id_siswa" name="id_siswa" required>
            <option value="">Pilih Siswa</option>
            @foreach($siswa as $s)
                <option value="{{ $s->id_siswa }}"
                    data-kelas="{{ $s->kelas->nama_kelas }}"
                    {{ old('id_siswa', $catatan->id_siswa) == $s->id_siswa ? 'selected' : '' }}>
                    {{ $s->nama_siswa }} - Kelas {{ $s->kelas->nama_kelas }}
                </option>
            @endforeach
        </select>
        @error('id_siswa')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="kelas_display">Kelas</label>
            <input type="text" id="kelas_display" value="{{ $catatan->siswa->kelas->nama_kelas }}" readonly>
        </div>
        <div class="form-group">
            <label for="semester">Semester <span class="required">*</span></label>
            <input type="number" id="semester" name="semester" value="{{ old('semester', $catatan->semester) }}" min="1" max="2" required>
        </div>
    </div>

    <div class="form-group">
        <label for="tahun_ajaran">Tahun Ajaran <span class="required">*</span></label>
        <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $catatan->tahun_ajaran) }}" required>
    </div>

    @foreach($kategori as $kat)
        @php
            $fieldName = strtolower(str_replace(['Nilai ', ' dan Budi Pekerti'], ['', ''], $kat->nama_kategori));
            $fieldName = str_replace(' ', '', $fieldName);
            $detail = $catatan->detailCatatan->firstWhere('id_kategori', $kat->id_kategori);
        @endphp
        <div class="form-group-pair">
            <div class="form-group">
                <label>{{ $kat->nama_kategori }}</label>
                <textarea
                    name="deskripsi_{{ $fieldName }}"
                    rows="3"
                    placeholder="Deskripsi {{ strtolower($kat->nama_kategori) }}..."
                >{{ old('deskripsi_' . $fieldName, $detail ? $detail->deskripsi : '') }}</textarea>
            </div>
        </div>
    @endforeach

    {{-- FOTO YANG ADA --}}
    @if($catatan->foto && $catatan->foto->count() > 0)
    <div class="section-foto">
        <div class="section-foto-header">
            <i class="fa-solid fa-images"></i>
            <span>Foto Terlampir</span>
        </div>
        <div class="foto-grid-existing">
            @foreach($catatan->foto as $foto)
            <div class="foto-card-existing" id="foto-card-{{ $foto->id_foto }}">
                <div class="foto-card-img-wrap">
                    <img src="{{ asset('storage/' . $foto->file_path) }}" alt="Foto">
                    <label class="foto-hapus-overlay" title="Tandai untuk dihapus">
                        <input type="checkbox"
                               name="hapus_foto[]"
                               value="{{ $foto->id_foto }}"
                               class="checkbox-hapus-foto"
                               id="hapus-{{ $foto->id_foto }}">
                        <span class="hapus-icon">
                            <i class="fa-solid fa-trash-can"></i>
                        </span>
                    </label>
                </div>
                @if($foto->keterangan)
                <div class="foto-card-caption">{{ $foto->keterangan }}</div>
                @endif
            </div>
            @endforeach
        </div>
        <p class="text-hint" style="margin-top:10px;">
            <i class="fa-solid fa-circle-info" style="color:#6366f1;margin-right:4px;"></i>
            Klik ikon hapus pada foto untuk menandai penghapusan
        </p>
    </div>
    @endif

    {{-- UPLOAD FOTO BARU --}}
    <div class="section-foto">
        <div class="section-foto-header">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Foto Baru (Opsional)</span>
        </div>
        <p class="text-hint">Format: JPG, PNG, GIF &nbsp;|&nbsp; Maks. 2MB per file</p>

        <div class="form-group" style="margin-bottom:14px;">
            <label for="foto">Pilih Foto</label>
            <input type="file" id="foto" name="foto[]" multiple accept="image/*">
            @error('foto.*')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <small class="text-hint">Gunakan Ctrl+Click untuk memilih banyak file</small>
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label for="keterangan_foto">Keterangan Foto (Opsional)</label>
            <input type="text" id="keterangan_foto" name="keterangan_foto"
                   placeholder="Misal: Kegiatan bermain, Hasil karya siswa, dll">
        </div>

        <div id="preview-container" class="preview-container" style="display:none;">
            <p style="font-size:12px;font-weight:600;color:#2b3674;margin-bottom:10px;">Preview Foto Baru:</p>
            <div id="preview-list" class="preview-list"></div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('guru.catatan.index') }}" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-submit">Update</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('id_siswa').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    document.getElementById('kelas_display').value = opt.getAttribute('data-kelas') || '';
});

document.getElementById('tahun_ajaran').addEventListener('blur', function () {
    let val = this.value.replace(/\D/g, '');
    if (val.length >= 4) {
        const y1 = val.substring(0, 4);
        const y2 = val.length >= 8 ? val.substring(4, 8) : parseInt(y1) + 1;
        this.value = `${y1}/${y2}`;
    }
});

document.getElementById('foto').addEventListener('change', function (e) {
    const files    = Array.from(e.target.files);
    const wrap     = document.getElementById('preview-container');
    const list     = document.getElementById('preview-list');
    list.innerHTML = '';
    if (!files.length) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';
    files.forEach((file, i) => {
        const reader  = new FileReader();
        reader.onload = function (e) {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview ${i + 1}">
                <p>${file.name}</p>
                <small>${(file.size / 1024).toFixed(1)} KB</small>
            `;
            list.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

// Tandai foto yang akan dihapus
document.querySelectorAll('.checkbox-hapus-foto').forEach(cb => {
    cb.addEventListener('change', function () {
        const card = this.closest('.foto-card-existing');
        if (this.checked) {
            card.classList.add('akan-dihapus');
        } else {
            card.classList.remove('akan-dihapus');
        }
    });
});
</script>
@endpush

@push('styles')
<style>
/* ===== FORM CONTAINER ===== */
.form-container {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    background: #ffffff;
    border: 1px solid #edf0f7;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(15,23,42,.04);
}

/* ===== FORM GROUP ===== */
.form-group,
.form-group-pair,
.section-foto {
    background: #ffffff;
    border: 1px solid #eef2ff;
    border-radius: 18px;
    padding: 20px;
    margin-bottom: 20px;
    transition: border-color .2s;
}
.form-group:hover,
.form-group-pair:hover,
.section-foto:hover {
    border-color: #dbe4ff;
}

/* ===== GRID ===== */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* ===== SECTION FOTO HEADER ===== */
.section-foto-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;
    color: #2b3674;
    margin-bottom: 14px;
}
.section-foto-header i {
    color: #6366f1;
    font-size: 15px;
}

/* ===== FOTO GRID EXISTING ===== */
.foto-grid-existing {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 12px;
}

.foto-card-existing {
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #eef2ff;
    background: #fafafa;
    transition: border-color .2s, opacity .2s;
}

.foto-card-existing.akan-dihapus {
    border-color: #fca5a5;
    opacity: 0.55;
}

.foto-card-img-wrap {
    position: relative;
    width: 100%;
    height: 120px;
    overflow: hidden;
}

.foto-card-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Tombol hapus overlay */
.foto-hapus-overlay {
    position: absolute;
    top: 6px;
    right: 6px;
    cursor: pointer;
}

.foto-hapus-overlay input[type="checkbox"] {
    display: none;
}

.hapus-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: rgba(255,255,255,0.92);
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,.12);
    color: #9ca3af;
    font-size: 12px;
    transition: background .18s, color .18s;
}

.foto-hapus-overlay:hover .hapus-icon {
    background: #fee2e2;
    color: #ef4444;
}

.foto-card-existing.akan-dihapus .hapus-icon {
    background: #fee2e2;
    color: #ef4444;
}

.foto-card-caption {
    padding: 6px 8px;
    font-size: 11px;
    color: #6b7280;
    background: #f9fafb;
    border-top: 1px solid #f0f0f5;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ===== PREVIEW FOTO BARU ===== */
.preview-container {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #eef2ff;
}

.preview-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 12px;
}

.preview-item {
    background: white;
    border: 1px solid #edf0f7;
    border-radius: 12px;
    padding: 8px;
    text-align: center;
}

.preview-item img {
    width: 100%;
    height: 90px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 6px;
    display: block;
}

.preview-item p {
    font-size: 11px;
    color: #374151;
    font-weight: 600;
    margin: 4px 0 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.preview-item small {
    font-size: 10px;
    color: #9ca3af;
}

/* ===== MISC ===== */
.required { color: #ef4444; }
.error-message { color: #ef4444; font-size: 12px; display: block; margin-top: 5px; }
.text-hint { font-size: 12px; color: #8b95b7; display: block; margin-top: 4px; }
textarea { resize: vertical; min-height: 120px; width: 100%; }

/* ===== ACTIONS ===== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 30px;
}

.btn-cancel {
    height: 42px;
    padding: 0 18px;
    border-radius: 12px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    color: #6b7280;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
    transition: .2s ease;
}
.btn-cancel:hover { background: #e5e7eb; color: #374151; }

.btn-submit {
    height: 42px;
    padding: 0 20px;
    border-radius: 12px;
    background: #f0fdf4;
    border: 1px solid #dcfce7;
    color: #22c55e;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s ease;
}
.btn-submit:hover { background: #dcfce7; color: #16a34a; transform: translateY(-1px); }

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .form-row { grid-template-columns: 1fr; }
    .foto-grid-existing { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); }
    .form-actions { flex-direction: column; }
    .btn-cancel, .btn-submit { width: 100%; justify-content: center; }
}
</style>
@endpush