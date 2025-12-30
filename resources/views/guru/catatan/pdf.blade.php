@extends('layouts.pdf')

@section('title', 'Laporan Perkembangan Siswa')

@section('print-date', now()->translatedFormat('d F Y, H:i:s'))

@section('content')
<div class="container">

    <div class="header">
        <h1>LAPORAN PERKEMBANGAN SISWA</h1>
        <p>TKIT Khaleefa El Rahman</p>
    </div>

    <div class="info-section">
        <div class="info-row"><strong>Nama Siswa</strong>: {{ $catatan->siswa->nama_siswa }}</div>
        <div class="info-row"><strong>Kelas</strong>: {{ $catatan->siswa->kelas->nama_kelas }}</div>
        <div class="info-row"><strong>Semester</strong>:  {{ $catatan->semester }}</div>
        <div class="info-row"><strong>Tahun Ajaran</strong>: {{ $catatan->tahun_ajaran }}</div>
        <div class="info-row"><strong>Tanggal</strong>: {{ \Carbon\Carbon::parse($catatan->tanggal_catat)->translatedFormat('d F Y') }}</div>
        <div class="info-row"><strong>Guru</strong>: {{ $catatan->user->nama_user }}</div>
    </div>

    <div class="section-title">PENILAIAN PERKEMBANGAN</div>

    <div class="penilaian-container">
        @forelse($catatan->detailCatatan as $detail)
            <div class="penilaian-box">
                <div class="penilaian-box-title">{{ $detail->kategori->nama_kategori }}</div>
                <div class="penilaian-box-content">{{ $detail->deskripsi }}</div>
            </div>
        @empty
            <div class="penilaian-box">
                <div class="penilaian-box-content" style="text-align: center; color: #999;">
                    Tidak ada data penilaian
                </div>
            </div>
        @endforelse
    </div>

    @if($catatan->foto && $catatan->foto->count())
        <div class="page-break"></div>

        @foreach($catatan->foto as $foto)
            <div class="lampiran-wrapper">
                <div class="lampiran-title">
                    LAMPIRAN DOKUMENTASI KEGIATAN
                </div>

                <div class="foto-frame">
                    <img src="{{ public_path('storage/' . $foto->file_path) }}">
                    <div class="foto-nama">
                        {{ basename($foto->file_path) }}
                    </div>
                    @if($foto->keterangan)
                        <div class="foto-keterangan">
                            {{ $foto->keterangan }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    <div class="signature">
        <div class="signature-box">
            <div class="signature-location">Bandung, {{ now()->translatedFormat('d F Y') }}</div>
            <div class="signature-role">Guru Pencatat</div>
            <strong>{{ $catatan->user->nama_user }}</strong>
        </div>
    </div>


</div>
@endsection