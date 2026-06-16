@extends('layouts.admin')
@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Data Siswa')

@section('content')
<div class="form-card">
    <div class="form-card-title">
        <div class="title-icon"><i class="fa-solid fa-user-plus"></i></div>
        Tambah Data Siswa Baru
    </div>

    <form action="{{ route('admin.siswa.store') }}" method="POST" class="form-container">
        @csrf

        <div class="form-group">
            <label for="nama_siswa">Nama Lengkap <span class="required">*</span></label>
            <input type="text" id="nama_siswa" name="nama_siswa"
                value="{{ old('nama_siswa') }}" required
                placeholder="Masukkan nama lengkap siswa">
            @error('nama_siswa')
                <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_kelas">Kelas <span class="required">*</span></label>
                <select id="id_kelas" name="id_kelas" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            Kelas {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('id_kelas')
                    <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki"  {{ old('jenis_kelamin') == 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan"  {{ old('jenis_kelamin') == 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                <input type="text" id="tempat_lahir" name="tempat_lahir"
                    value="{{ old('tempat_lahir') }}" required placeholder="Contoh: Bandung">
                @error('tempat_lahir')
                    <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                    value="{{ old('tanggal_lahir') }}" required>
                @error('tanggal_lahir')
                    <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nama_ayah">Nama Ayah</label>
                <input type="text" id="nama_ayah" name="nama_ayah"
                    value="{{ old('nama_ayah') }}" placeholder="Masukkan nama ayah">
            </div>

            <div class="form-group">
                <label for="nama_ibu">Nama Ibu</label>
                <input type="text" id="nama_ibu" name="nama_ibu"
                    value="{{ old('nama_ibu') }}" placeholder="Masukkan nama ibu">
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3"
                placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.siswa.index') }}" class="btn-cancel">
                <i class="fa-solid fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
