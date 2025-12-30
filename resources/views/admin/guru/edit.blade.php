@extends('layouts.admin')

@section('title', 'Edit Guru')
@section('page-title', 'Edit Akun Guru')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.guru.update', $guru->id_user) }}" method="POST" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_user">Nama Lengkap <span class="required">*</span></label>
            <input
                type="text"
                id="nama_user"
                name="nama_user"
                value="{{ old('nama_user', $guru->nama_user) }}"
                required>
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
                    value="{{ old('username', $guru->username) }}"
                    required>
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
                    value="{{ old('email', $guru->email) }}"
                    required>
                @error('email')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Kosongkan jika tidak ingin mengubah">
                <small style="color: #666;">Kosongkan jika tidak ingin mengubah password</small>
                @error('password')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ketik ulang password baru">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input
                    type="text"
                    id="no_hp"
                    name="no_hp"
                    value="{{ old('no_hp', $guru->no_hp) }}"
                    maxlength="15"
                    placeholder="Contoh: 081234567890"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" required>
                    <option value="aktif" {{ old('status', $guru->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $guru->status) == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.guru.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit"> Update</button>
        </div>
    </form>
</div>
@endsection