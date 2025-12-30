@extends('layouts.guru')

@section('title', 'Detail Catatan')
@section('page-title', 'Detail Pencatatan')

@section('content')
<div class="halaman-detail">
   
    <div class="header-dialog">
        <a href="{{ route('guru.catatan.index') }}" class="tombol-kembali">← Kembali</a>
        <h2>Detail Pencatatan</h2>
        <div style="width: 120px;"></div> 
    </div>

    <div class="isi-dialog">
        <div class="kotak-data">
            <div class="baris-data">
                <p><strong>Nama</strong>: <span>{{ $catatan->siswa->nama_siswa }}</span></p>
                <p><strong>Kelas</strong>: <span>{{ $catatan->siswa->kelas->nama_kelas }}</span></p>
                <p><strong>Semester</strong>: <span>{{ $catatan->semester }}</span></p>
                <p><strong>Tahun Ajaran</strong>: <span>{{ $catatan->tahun_ajaran }}</span></p>
                <p><strong>Tanggal Pencatatan</strong>: <span>{{ \Carbon\Carbon::parse($catatan->tanggal_catat)->format('d F Y') }}</span></p>
                <p><strong>Dicatat Oleh</strong>: <span>{{ $catatan->user->nama_user }}</span></p>
            </div>

            @foreach($catatan->detailCatatan as $detail)
                <hr>
                <div class="baris-data">
                    <p><strong>{{ $detail->kategori->nama_kategori }}</strong></p>
                    <p class="deskripsi-text">{{ $detail->deskripsi }}</p>
                </div>
            @endforeach

            @if($catatan->foto && $catatan->foto->count() > 0)
                <hr>
                <div class="baris-data">
                    <p><strong>Lampiran Gambar</strong></p>
                    <div class="lampiran-container">
                        @foreach($catatan->foto as $foto)
                            <div class="lampiran-item">
                                <img src="{{ asset('storage/' . $foto->file_path) }}" alt="{{ $foto->file_name }}">
                                <p class="lampiran-filename">{{ $foto->file_name }}</p>
                                @if($foto->keterangan)
                                    <small class="lampiran-keterangan">{{ $foto->keterangan }}</small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

      
        <div style="text-align: right;">
            <a href="{{ route('guru.catatan.pdf', $catatan->id_catatan) }}" class="tombol-cetak-bawah" target="_blank">
                📄 Cetak PDF
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.halaman-detail {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* HEADER */
.header-dialog {
    background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    color: white;
    padding: 18px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
}

.header-dialog h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
    flex: 1;
    text-align: center;
}

.tombol-kembali {
    padding: 9px 18px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s;
    display: inline-block;
}

.tombol-kembali:hover {
    background: rgba(255, 255, 255, 0.35);
    transform: translateY(-1px);
}


.isi-dialog {
    padding: 28px;
    background: #f0f9ff;
}

.kotak-data {
    background: #ffffff;
    padding: 24px;
    border-radius: 10px;
    border: 1px solid #93c5fd;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.baris-data {
    margin-bottom: 14px;
}

.baris-data:last-child {
    margin-bottom: 0;
}

.baris-data p {
    margin: 6px 0;
    line-height: 1.7;
    font-size: 14px;
    color: #1e293b;
}

.baris-data strong {
    color: #1e40af;
    font-weight: 700;
}

.deskripsi-text {
    margin-top: 10px;
    padding: 16px;
    background: #f8fafc;
    border-left: 4px solid #3b82f6;
    border-radius: 6px;
    line-height: 1.8;
    color: #334155;
}

hr {
    border: none;
    border-top: 2px dashed #bfdbfe;
    margin: 18px 0;
}


.tombol-cetak-bawah {
    display: inline-block;
    padding: 14px 40px;
    background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    text-decoration: none;
    font-weight: 700;
    font-size: 15px;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}

.tombol-cetak-bawah:hover {
    background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
    box-shadow: 0 6px 16px rgba(22, 163, 74, 0.4);
    transform: translateY(-2px);
    color: white;
}

.tombol-cetak-bawah:active {
    transform: translateY(0);
}

/* Lampiran Gambar Styles */
.lampiran-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.lampiran-item {
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px;
    background: white;
    text-align: center;
    transition: all 0.3s;
}

.lampiran-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    border-color: #3b82f6;
}

.lampiran-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s;
}

.lampiran-item img:hover {
    transform: scale(1.05);
}

.lampiran-filename {
    margin: 12px 0 5px 0;
    font-size: 13px;
    color: #1e293b;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.lampiran-keterangan {
    display: block;
    font-size: 12px;
    color: #64748b;
    font-style: italic;
    margin-top: 4px;
}


@media (max-width: 768px) {
    .header-dialog {
        padding: 14px 18px;
    }
    
    .header-dialog h2 {
        font-size: 17px;
    }
    
    .tombol-kembali {
        padding: 8px 14px;
        font-size: 13px;
    }
    
    .isi-dialog {
        padding: 20px;
    }
    
    .kotak-data {
        padding: 18px;
    }
    
    .lampiran-container {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }
    
    .lampiran-item img {
        height: 150px;
    }
    
    .tombol-cetak-bawah {
        padding: 12px 30px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .lampiran-container {
        grid-template-columns: 1fr;
    }
    
    
    .tombol-cetak-bawah {
        display: block;
        margin-left: auto;
        width: fit-content;
    }
}
</style>
@endpush

@push('scripts')
<script>

document.querySelectorAll('.lampiran-item img').forEach(img => {
    img.addEventListener('click', function() {
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.92);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            cursor: pointer;
            animation: fadeIn 0.2s ease;
        `;
        
        const modalImg = document.createElement('img');
        modalImg.src = this.src;
        modalImg.style.cssText = `
            max-width: 90%; 
            max-height: 90%; 
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        `;
        
        modal.appendChild(modalImg);
        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
        
        modal.addEventListener('click', function() {
            document.body.removeChild(modal);
            document.body.style.overflow = 'auto';
        });
    });
});
</script>
@endpush