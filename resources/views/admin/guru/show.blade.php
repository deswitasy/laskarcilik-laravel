@extends('layouts.admin')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Akun Guru')

@section('content')
<div class="detail-card">
    <div class="detail-header">
        <h2>{{ $guru->nama_user }}</h2>
        <div class="detail-actions">
            <a href="{{ route('admin.guru.edit', $guru->id_user) }}" class="btn btn-edit">
                ✏️ Edit
            </a>
            <a href="{{ route('admin.guru.index') }}" class="btn btn-back">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="detail-content">
        <div class="info-section">
            <h3>Informasi Akun</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap:</span>
                    <span class="info-value">{{ $guru->nama_user }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Username:</span>
                    <span class="info-value">{{ $guru->username }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $guru->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">No HP:</span>
                    <span class="info-value">{{ $guru->no_hp ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="badge badge-{{ $guru->status === 'aktif' ? 'success' : 'secondary' }}">
                        {{ ucfirst($guru->status) }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Terdaftar Sejak:</span>
                    <span class="info-value">{{ $guru->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Statistik</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Total Catatan Dibuat:</span>
                    <span class="info-value">{{ $totalCatatan }} catatan</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Catatan Bulan Ini:</span>
                    <span class="info-value">{{ $catatanBulanIni }} catatan</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
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

    .badge-secondary {
        background: #FF6B6B;
        color: white;
    }
</style>
@endpush