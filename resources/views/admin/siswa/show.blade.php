@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Data Siswa')

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
                    Kelas {{ $siswa->kelas->nama_kelas }} &middot; {{ ucfirst($siswa->status_siswa) }}
                </p>
            </div>
        </div>
        <div class="detail-actions">
            <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}" class="btn-detail-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="btn-detail-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="detail-content">
        <div class="info-section">
            <h3>Informasi Pribadi</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $siswa->nama_siswa }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kelamin</span>
                    <span class="info-value">{{ $siswa->jenis_kelamin }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tempat Lahir</span>
                    <span class="info-value">{{ $siswa->tempat_lahir }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Lahir</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Usia</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }} tahun</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Informasi Akademik</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Kelas</span>
                    <span class="info-value">{{ $siswa->kelas->nama_kelas }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="badge badge-{{ $siswa->status_siswa === 'aktif' ? 'success' : 'secondary' }}">
                            {{ ucfirst($siswa->status_siswa) }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Informasi Orang Tua</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Ayah</span>
                    <span class="info-value">{{ $siswa->nama_ayah ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nama Ibu</span>
                    <span class="info-value">{{ $siswa->nama_ibu ?? '-' }}</span>
                </div>
                <div class="info-item full-width">
                    <span class="info-label">Alamat</span>
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
                                <td><span class="badge badge-success">{{ $catatan->detailCatatan->count() }} aspek</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state" style="padding: 30px; text-align: center; color: var(--text-light);">
                    <i class="fa-solid fa-clipboard" style="font-size: 28px; opacity: .3; display: block; margin-bottom: 8px;"></i>
                    Belum ada catatan perkembangan untuk siswa ini
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
