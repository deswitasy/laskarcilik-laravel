@extends('layouts.guru')

@section('title', 'Tambah Catatan')
@section('page-title', 'Tambah Catatan Perkembangan Siswa')

@section('content')
<form action="{{ route('guru.catatan.store') }}" method="POST" class="form-container" id="studentForm" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="id_siswa">Nama Lengkap <span class="required">*</span></label>
        <select id="id_siswa" name="id_siswa" class="@error('id_siswa') is-invalid @enderror" required>
            <option value="">Pilih Siswa</option>
            @foreach($siswa as $s)
                <option value="{{ $s->id_siswa }}" 
                    data-kelas="{{ $s->kelas->nama_kelas }}"
                    {{ request('siswa') == $s->id_siswa ? 'selected' : '' }}
                    {{ old('id_siswa') == $s->id_siswa ? 'selected' : '' }}>
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
            <input type="text" id="kelas_display" value="" readonly>
        </div>
        <div class="form-group">
            <label for="semester">Semester <span class="required">*</span></label>
            <input type="number" id="semester" name="semester" class="@error('semester') is-invalid @enderror" value="{{ old('semester', 1) }}" min="1" max="2" required>
            @error('semester')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="tahun_ajaran">Tahun Ajaran <span class="required">*</span></label>
        <input type="text" id="tahun_ajaran" name="tahun_ajaran" class="@error('tahun_ajaran') is-invalid @enderror" value="{{ old('tahun_ajaran', '2024/2025') }}" required placeholder="2024/2025">
        @error('tahun_ajaran')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    @foreach($kategori as $kat)
        @php
            $fieldName = strtolower(str_replace(['Nilai ', ' dan Budi Pekerti'], ['', ''], $kat->nama_kategori));
            $fieldName = str_replace(' ', '', $fieldName);
        @endphp
        <div class="form-group-pair">
            <div class="form-group">
                <label>{{ $kat->nama_kategori }} <span class="required">*</span></label>
                <textarea 
                    name="deskripsi_{{ $fieldName }}" 
                    id="deskripsi_{{ $fieldName }}"
                    class="@error('deskripsi_' . $fieldName) is-invalid @enderror"
                    rows="3" 
                    placeholder="Deskripsi {{ strtolower($kat->nama_kategori) }}..."
                >{{ old('deskripsi_' . $fieldName) }}</textarea>
                @error('deskripsi_' . $fieldName)
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach

    <div class="section-foto">
        <h3>📸 Lampiran Gambar (Opsional)</h3>
        <p class="text-hint">Anda dapat menambahkan foto/gambar untuk mendukung pencatatan ini. Format: JPG, PNG, GIF | Max 2MB per file</p>
        
        <div class="form-group">
            <label for="foto">Pilih Foto</label>
            <input type="file" id="foto" name="foto[]" multiple accept="image/*">
            @error('foto.*')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <small class="text-hint">Gunakan Ctrl+Click untuk memilih banyak file sekaligus</small>
        </div>

        <div class="form-group">
            <label for="keterangan_foto">Keterangan Foto (Opsional)</label>
            <input type="text" id="keterangan_foto" name="keterangan_foto" placeholder="Misal: Kegiatan bermain, Hasil karya siswa, dll">
        </div>

        <div id="preview-container" class="preview-container" style="display: none;">
            <h4>Preview Gambar:</h4>
            <div id="preview-list" class="preview-list"></div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('guru.catatan.index') }}" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-submit">Simpan</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('id_siswa').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const kelas = selectedOption.getAttribute('data-kelas');
    document.getElementById('kelas_display').value = kelas || '';
});

window.addEventListener('DOMContentLoaded', function() {
    const siswaSelect = document.getElementById('id_siswa');
    if (siswaSelect.value) {
        siswaSelect.dispatchEvent(new Event('change'));
    }
});

document.getElementById('tahun_ajaran').addEventListener('blur', function() {
    let val = this.value.replace(/\D/g, '');
    if (val.length >= 4) {
        const y1 = val.substring(0, 4);
        const y2 = val.length >= 8 ? val.substring(4, 8) : parseInt(y1) + 1;
        this.value = `${y1}/${y2}`;
    }
});

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

@if ($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        const firstError = document.querySelector('.is-invalid');
        
        if (firstError) {
            setTimeout(() => {
                firstError.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                
                setTimeout(() => {
                    firstError.focus();
                    
                    // efek highlight/shake
                    firstError.style.transition = 'all 0.3s';
                    firstError.style.boxShadow = '0 0 15px rgba(220, 53, 69, 0.5)';
                    
                    // Shake animation
                    firstError.classList.add('animate-shake');
                    
                    // Hapus shadow setelah 2 detik
                    setTimeout(() => {
                        firstError.style.boxShadow = '';
                        firstError.classList.remove('animate-shake');
                    }, 2000);
                }, 500);
            }, 100);
        }
    });
@endif
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

/* Styling untuk field yang error */
.is-invalid {
    border: 2px solid #dc3545 !important;
    background-color: #fff5f5 !important;
}

/* Section Foto Styles */
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

/* Animasi Shake untuk field error */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.6s;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .preview-list {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }
}
</style>
@endpush