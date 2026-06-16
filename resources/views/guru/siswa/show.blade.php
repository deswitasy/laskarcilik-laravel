@extends('layouts.guru')
@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

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
                                        <a href="{{ route('guru.catatan.show', $catatan->id_catatan) }}" class="btn-detail">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>
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