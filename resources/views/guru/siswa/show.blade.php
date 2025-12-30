@extends('layouts.guru')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

@section('content')
<div class="detail-card">
    <div class="detail-header">
        <h2>{{ $siswa->nama_siswa }}</h2>
        <div class="detail-actions">
            <a href="{{ route('guru.catatan.create', ['siswa' => $siswa->id_siswa]) }}" class="btn btn-add">
                ➕ Buat Catatan
            </a>
            <a href="{{ route('guru.siswa.index') }}" class="btn btn-back">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="detail-content">
        <div class="info-section">
            <h3>Informasi Siswa</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap:</span>
                    <span class="info-value">{{ $siswa->nama_siswa }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kelas:</span>
                    <span class="info-value">{{ $siswa->kelas->nama_kelas }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kelamin:</span>
                    <span class="info-value">{{ $siswa->jenis_kelamin }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Usia:</span>
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
                                        <a href="{{ route('guru.catatan.show', $catatan->id_catatan) }}" class="btn btn-detail">
                                            ⓘ Lihat
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 20px;">
                    Anda belum membuat catatan untuk siswa ini
                </p>
            @endif
        </div>
    </div>
</div>
@endsection