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

    <!-- SECTION: FOTO YANG ADA -->
    @if($catatan->foto && $catatan->foto->count() > 0)
        <div class="section-foto-existing">
            <h3>📷 Foto yang Ada</h3>
            <div class="foto-list-existing">
                @foreach($catatan->foto as $foto)
                    <div class="foto-item-existing">
                        <img src="{{ asset('storage/' . $foto->file_path) }}" alt="Foto">
                        <div class="foto-info">
                            <p class="foto-name">Foto ID: {{ $foto->id_foto }}</p>
                            @if($foto->keterangan)
                                <small class="foto-keterangan">{{ $foto->keterangan }}</small>
                            @endif
                        </div>
                        <label class="checkbox-hapus">
                            <input type="checkbox" name="hapus_foto[]" value="{{ $foto->id_foto }}">
                            <span>Hapus</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- SECTION: UPLOAD FOTO BARU -->
    <div class="section-foto">
        <h3>➕ Tambah Foto Baru (Opsional)</h3>
        <p class="text-hint">Format: JPG, PNG, GIF | Max 2MB per file</p>
        
        <div class="form-group">
            <label for="foto">Pilih Foto</label>
            <input type="file" id="foto" name="foto[]" multiple accept="image/*">
            @error('foto.*')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <small class="text-hint">Gunakan Ctrl+Click untuk memilih banyak file</small>
        </div>

        <div class="form-group">
            <label for="keterangan_foto">Keterangan Foto (Opsional)</label>
            <input type="text" id="keterangan_foto" name="keterangan_foto" placeholder="Misal: Kegiatan bermain, Hasil karya siswa, dll">
        </div>

        <!-- Preview gambar baru -->
        <div id="preview-container" class="preview-container" style="display: none;">
            <h4>Preview Gambar Baru:</h4>
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
// Auto fill kelas
document.getElementById('id_siswa').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const kelas = selectedOption.getAttribute('data-kelas');
    document.getElementById('kelas_display').value = kelas || '';
});

// Format tahun ajaran
document.getElementById('tahun_ajaran').addEventListener('blur', function() {
    let val = this.value.replace(/\D/g, '');
    if (val.length >= 4) {
        const y1 = val.substring(0, 4);
        const y2 = val.length >= 8 ? val.substring(4, 8) : parseInt(y1) + 1;
        this.value = `${y1}/${y2}`;
    }
});

// Preview gambar baru
document.getElementById('foto').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const previewContainer = document.getElementById('preview-container');
    const previewList = document.getElementById('preview-list');
    
    previewList.innerHTML = '';
    
    if (files.length > 0) {
        previewContainer.style.display = 'block';
        
        files.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}">
                    <p>${file.name}</p>
                    <small>${(file.size / 1024).toFixed(2)} KB</small>
                `;
                previewList.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        });
    } else {
        previewContainer.style.display = 'none';
    }
});

// Konfirmasi sebelum hapus foto
document.querySelectorAll('.checkbox-hapus input').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            const parent = this.closest('.foto-item-existing');
            parent.style.opacity = '0.5';
            parent.style.textDecoration = 'line-through';
        } else {
            const parent = this.closest('.foto-item-existing');
            parent.style.opacity = '1';
            parent.style.textDecoration = 'none';
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group-pair {
    margin-bottom: 20px;
}

.required {
    color: red;
}

.error-message {
    color: red;
    font-size: 12px;
    display: block;
    margin-top: 5px;
}

.text-hint {
    font-size: 12px;
    color: #666;
    display: block;
    margin-top: 5px;
}

.btn-cancel {
    padding: 10px 20px;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.btn-cancel:hover {
    background: #5a6268;
}

.btn-submit {
    padding: 10px 20px;
    background: #275CB4;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
}

.btn-submit:hover {
    background: #1a4480;
}

/* Section Foto Existing */
.section-foto-existing {
    background: #e7f3ff;
    border: 2px solid #275CB4;
    border-radius: 8px;
    padding: 20px;
    margin: 30px 0;
}

.section-foto-existing h3 {
    color: #275CB4;
    margin-top: 0;
    margin-bottom: 15px;
}

.foto-list-existing {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
}

.foto-item-existing {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    transition: all 0.3s;
    position: relative;
}

.foto-item-existing img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 8px;
}

.foto-info {
    margin-bottom: 10px;
}

.foto-name {
    font-size: 12px;
    font-weight: 600;
    color: #333;
    margin: 5px 0;
}

.foto-keterangan {
    font-size: 11px;
    color: #666;
    display: block;
}

.checkbox-hapus {
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    font-size: 12px;
    color: #d9534f;
}

.checkbox-hapus input {
    cursor: pointer;
}

/* Section Foto Baru */
.section-foto {
    background: #f8f9fa;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin: 30px 0;
}

.section-foto h3 {
    color: #275CB4;
    margin-top: 0;
    margin-bottom: 10px;
}

.section-foto p {
    margin: 5px 0;
}

/* Preview Container */
.preview-container {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #dee2e6;
}

.preview-container h4 {
    color: #333;
    margin-bottom: 15px;
}

.preview-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
}

.preview-item {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.preview-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.preview-item img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 8px;
}

.preview-item p {
    font-size: 12px;
    color: #333;
    margin: 5px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 600;
}

.preview-item small {
    font-size: 11px;
    color: #666;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .foto-list-existing {
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    }
    
    .preview-list {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }
}
</style>
@endpush