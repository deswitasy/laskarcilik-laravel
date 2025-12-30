@extends('layouts.admin')

@section('title', 'Tambah Guru')
@section('page-title', 'Tambah Akun Guru')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.guru.store') }}" method="POST" class="form-container">
        @csrf

        <div class="form-group">
            <label for="nama_user">Nama Lengkap <span class="required">*</span></label>
            <input 
                type="text" 
                id="nama_user" 
                name="nama_user" 
                value="{{ old('nama_user') }}" 
                required
                placeholder="Masukkan nama lengkap guru"
            >
            @error('nama_user')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="username">Username <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="{{ old('username') }}" 
                    required
                    placeholder="Username untuk login"
                >
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    placeholder="email@example.com"
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    placeholder="Minimal 6 karakter"
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                    placeholder="Ketik ulang password"
                >
            </div>
        </div>

        <div class="form-group">
            <label for="no_hp">No HP</label>
            <input 
                type="text" 
                id="no_hp" 
                name="no_hp" 
                value="{{ old('no_hp', $guru->no_hp ?? '') }}"
                placeholder="08xxxxxxxxxx"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                maxlength="15"
            >
            @error('no_hp')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.guru.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit"> Simpan</button>
        </div>
    </form>
</div>
@endsection