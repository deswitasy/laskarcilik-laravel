@extends('layouts.admin')
@section('title', 'Detail Guru')
@section('page-title', 'Detail Akun Guru')

@section('content')
<div class="detail-card">
    <div class="detail-header">
        <div class="detail-header-info">
            <div class="detail-avatar">
                {{ strtoupper(substr($guru->nama_user, 0, 1)) }}
            </div>
            <div>
                <h2>{{ $guru->nama_user }}</h2>
                <p class="detail-header-sub">
                    @username: {{ $guru->username }} &middot;
                    <span class="badge badge-{{ $guru->status === 'aktif' ? 'success' : 'secondary' }}"
                          style="font-size: 11px; padding: 2px 10px;">
                        {{ ucfirst($guru->status) }}
                    </span>
                </p>
            </div>
        </div>
        <div class="detail-actions">
            <a href="{{ route('admin.guru.edit', $guru->id_user) }}" class="btn-detail-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            <a href="{{ route('admin.guru.index') }}" class="btn-detail-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="detail-content">
        <div class="info-section">
            <h3>Informasi Akun</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $guru->nama_user }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Username</span>
                    <span class="info-value">{{ $guru->username }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $guru->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">No HP</span>
                    <span class="info-value">{{ $guru->no_hp ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="badge badge-{{ $guru->status === 'aktif' ? 'success' : 'secondary' }}">
                            {{ ucfirst($guru->status) }}
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Terdaftar Sejak</span>
                    <span class="info-value">{{ $guru->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Statistik Aktivitas</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Total Catatan Dibuat</span>
                    <span class="info-value" style="font-size: 24px; font-weight: 800; color: var(--primary);">
                        {{ $totalCatatan }}
                        <small style="font-size: 14px; font-weight: 500; color: var(--text-light);">catatan</small>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Catatan Bulan Ini</span>
                    <span class="info-value" style="font-size: 24px; font-weight: 800; color: var(--accent-green);">
                        {{ $catatanBulanIni }}
                        <small style="font-size: 14px; font-weight: 500; color: var(--text-light);">catatan</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection