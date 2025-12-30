@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Data Siswa')

@section('content')
<div class="detail-card">
    <div class="detail-header">
        <h2>{{ $siswa->nama_siswa }}</h2>
        <div class="detail-actions">
            <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}" class="btn btn-edit">
                ✏️ Edit
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-back">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="detail-content">
        <div class="info-section">
            <h3>Informasi Pribadi</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap:</span>
                    <span class="info-value">{{ $siswa->nama_siswa }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kelamin:</span>
                    <span class="info-value">{{ $siswa->jenis_kelamin }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tempat Lahir:</span>
                    <span class="info-value">{{ $siswa->tempat_lahir }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Lahir:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Usia:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }} tahun</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Informasi Akademik</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Kelas:</span>
                    <span class="info-value">{{ $siswa->kelas->nama_kelas }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="badge badge-{{ $siswa->status_siswa === 'aktif' ? 'success' : 'secondary' }}">
                        {{ ucfirst($siswa->status_siswa) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Informasi Orang Tua</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Ayah:</span>
                    <span class="info-value">{{ $siswa->nama_ayah ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nama Ibu:</span>
                    <span class="info-value">{{ $siswa->nama_ibu ?? '-' }}</span>
                </div>
                <div class="info-item full-width">
                    <span class="info-label">Alamat:</span>
                    <span class="info-value">{{ $siswa->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Riwayat Catatan Perkembangan</h3>
            @if($siswa->catatanPerkembangan->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Guru</th>
                                <th>Jumlah Aspek</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa->catatanPerkembangan as $index => $catatan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($catatan->tanggal_catat)->format('d-m-Y') }}</td>
                                <td>{{ $catatan->semester }}</td>
                                <td>{{ $catatan->tahun_ajaran }}</td>
                                <td>{{ $catatan->user->nama_user }}</td>
                                <td>{{ $catatan->detailCatatan->count() }} aspek</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 20px;">
                    Belum ada catatan perkembangan untuk siswa ini
                </p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.detail-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}
.detail-header {
    background: linear-gradient(135deg, #275CB4 0%, #1a4480 100%);
    color: white;
    padding: 25px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.detail-header h2 {
    margin: 0;
    font-size: 24px;
}
.detail-actions {
    display: flex;
    gap: 10px;
}
.detail-content {
    padding: 30px;
}
.info-section {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}
.info-section:last-child {
    border-bottom: none;
}
.info-section h3 {
    color: #275CB4;
    margin-bottom: 15px;
    font-size: 18px;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}
.info-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.info-item.full-width {
    grid-column: 1 / -1;
}
.info-label {
    font-weight: 600;
    color: #666;
    font-size: 14px;
}
.info-value {
    color: #333;
    font-size: 16px;
}
.btn-back {
    background: white;
    color: #275CB4;
    border: 2px solid white;
}
.badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        width: fit-content;
    }

    .badge-success {
        background: #275CB4;
        color: white;
    }

    
</style>
@endpush