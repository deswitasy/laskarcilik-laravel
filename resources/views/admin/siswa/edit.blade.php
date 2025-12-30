@extends('layouts.admin')

@section('title', 'Edit Siswa')
@section('page-title', 'Edit Data Siswa')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.siswa.update', $siswa->id_siswa) }}" method="POST" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_siswa">Nama Lengkap <span class="required">*</span></label>
            <input 
                type="text" 
                id="nama_siswa" 
                name="nama_siswa" 
                value="{{ old('nama_siswa', $siswa->nama_siswa) }}" 
                required
            >
            @error('nama_siswa')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_kelas">Kelas <span class="required">*</span></label>
                <select id="id_kelas" name="id_kelas" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id_kelas }}" 
                            {{ old('id_kelas', $siswa->id_kelas) == $k->id_kelas ? 'selected' : '' }}>
                            Kelas {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('id_kelas')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="tempat_lahir" 
                    name="tempat_lahir" 
                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" 
                    required
                >
                @error('tempat_lahir')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                <input 
                    type="date" 
                    id="tanggal_lahir" 
                    name="tanggal_lahir" 
                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir->format('Y-m-d')) }}" 
                    required
                >
                @error('tanggal_lahir')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nama_ayah">Nama Ayah</label>
                <input 
                    type="text" 
                    id="nama_ayah" 
                    name="nama_ayah" 
                    value="{{ old('nama_ayah', $siswa->nama_ayah) }}"
                >
            </div>

            <div class="form-group">
                <label for="nama_ibu">Nama Ibu</label>
                <input 
                    type="text" 
                    id="nama_ibu" 
                    name="nama_ibu" 
                    value="{{ old('nama_ibu', $siswa->nama_ibu) }}"
                >
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea 
                id="alamat" 
                name="alamat" 
                rows="3"
            >{{ old('alamat', $siswa->alamat) }}</textarea>
        </div>

        <div class="form-group">
            <label for="status_siswa">Status Siswa <span class="required">*</span></label>
            <select id="status_siswa" name="status_siswa" required>
                <option value="aktif" {{ old('status_siswa', $siswa->status_siswa) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="lulus" {{ old('status_siswa', $siswa->status_siswa) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="pindah" {{ old('status_siswa', $siswa->status_siswa) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                <option value="keluar" {{ old('status_siswa', $siswa->status_siswa) == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
            @error('status_siswa')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.siswa.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit"> Update</button>
        </div>
    </form>
</div>
@endsection