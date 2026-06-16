@php
    $isPdf = $isPdf ?? false;
    $logoPath = public_path('assets/logo-tk.jpeg');
    $logoSrc = null;

    if ($isPdf && file_exists($logoPath)) {
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;
    } elseif (!$isPdf) {
        $logoSrc = asset('assets/logo-tk.jpeg');
    }

    $fotoItems = $catatan->foto ?? collect();
    if ($isPdf) {
        $fotoItems = $fotoItems
            ->filter(function ($foto) {
                return file_exists(public_path('storage/' . $foto->file_path));
            })
            ->values();
    }
@endphp

<div class="paper-doc-content">

    {{-- KOP SURAT --}}
    <div class="kop">
        @if ($logoSrc)
            <img src="{{ $logoSrc }}" alt="Logo" class="kop-logo"
                @unless ($isPdf) onerror="this.style.display='none'" @endunless>
        @else
            <div class="kop-logo"
                style="background:#f2f2f2;display:flex;align-items:center;justify-content:center;font-size:8px;color:#666;">
                LOGO
            </div>
        @endif
        <div class="kop-teks">
            <div class="kop-nama">TKIT KHALEEFA EL RAHMAN</div>
            <div class="kop-alamat">Jl. Makmur Utama No.488, Cibeber, Kec. Cimahi Sel., Kota Cimahi &nbsp;·&nbsp; Telp.
                0821-1213-2025</div>
        </div>
        <div class="kop-right">
            <div class="kop-tahun-ajaran">Tahun Ajaran</div>
            <div class="kop-badge-ta">{{ $catatan->tahun_ajaran }}</div>
        </div>
    </div>
    <div class="kop-divider-warna"></div>

    {{-- JUDUL --}}
    <div class="judul-dokumen">
        <h2>Catatan Perkembangan Siswa</h2>
        <div class="judul-garis"></div>
    </div>

    {{-- IDENTITAS --}}
    <table class="tabel-identitas">
        <tr>
            <td class="label-col">Nama Siswa</td>
            <td class="titik-col">:</td>
            <td class="nilai-col">{{ $catatan->siswa->nama_siswa }}</td>
        </tr>
        <tr>
            <td class="label-col">Kelas</td>
            <td class="titik-col">:</td>
            <td class="nilai-col">{{ $catatan->siswa->kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td class="label-col">Semester</td>
            <td class="titik-col">:</td>
            <td class="nilai-col">{{ $catatan->semester }}</td>
        </tr>
        <tr>
            <td class="label-col">Tahun Ajaran</td>
            <td class="titik-col">:</td>
            <td class="nilai-col">{{ $catatan->tahun_ajaran }}</td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Pencatatan</td>
            <td class="titik-col">:</td>
            <td class="nilai-col">{{ \Carbon\Carbon::parse($catatan->tanggal_catat)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label-col">Dicatat Oleh</td>
            <td class="titik-col">:</td>
            <td class="nilai-col">{{ $catatan->user->nama_user }}</td>
        </tr>
    </table>

    {{-- ASPEK PERKEMBANGAN --}}
    <div class="section-heading">Aspek Perkembangan</div>
    <div class="aspek-list">
        @foreach ($catatan->detailCatatan as $detail)
            <div class="aspek-item">
                <div class="aspek-nama">{{ $detail->kategori->nama_kategori }}</div>
                <div class="aspek-deskripsi">{{ $detail->deskripsi }}</div>
            </div>
        @endforeach
    </div>

    {{-- LAMPIRAN --}}
    @if ($fotoItems->count() > 0)
        <hr class="divider-dashed">
        <div class="section-heading">Lampiran Dokumentasi</div>
        @if ($isPdf)
            <table class="foto-grid">
                @foreach ($fotoItems->chunk(3) as $fotoChunk)
                    <tr>
                        @foreach ($fotoChunk as $foto)
                            @php
                                $fotoPath = public_path('storage/' . $foto->file_path);
                                if ($isPdf && file_exists($fotoPath)) {
                                    $fotoData = base64_encode(file_get_contents($fotoPath));
                                    $fotoSrc = 'data:image/jpeg;base64,' . $fotoData;
                                } else {
                                    $fotoSrc = asset('storage/' . $foto->file_path);
                                }
                            @endphp
                            <td class="foto-item">
                                <img src="{{ $fotoSrc }}" alt="{{ $foto->file_name }}"
                                    @unless ($isPdf) onerror="this.style.display='none'" @endunless>
                                <div class="foto-caption">
                                    {{ $foto->file_name }}
                                    @if ($foto->keterangan)
                                        <span class="foto-ket">{{ $foto->keterangan }}</span>
                                    @endif
                                </div>
                            </td>
                        @endforeach
                        @for ($i = $fotoChunk->count(); $i < 3; $i++)
                            <td class="foto-item empty"></td>
                        @endfor
                    </tr>
                @endforeach
            </table>
        @else
            <div class="foto-grid">
                @foreach ($fotoItems as $foto)
                    @php
                        $fotoPath = public_path('storage/' . $foto->file_path);
                        if ($isPdf && file_exists($fotoPath)) {
                            $fotoData = base64_encode(file_get_contents($fotoPath));
                            $fotoSrc = 'data:image/jpeg;base64,' . $fotoData;
                        } else {
                            $fotoSrc = asset('storage/' . $foto->file_path);
                        }
                    @endphp
                    <div class="foto-item">
                        <img src="{{ $fotoSrc }}" alt="{{ $foto->file_name }}"
                            @unless ($isPdf) onerror="this.style.display='none'" @endunless>
                        <div class="foto-caption">
                            {{ $foto->file_name }}
                            @if ($foto->keterangan)
                                <span class="foto-ket">{{ $foto->keterangan }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    {{-- TANDA TANGAN --}}
    <div class="ttd-area">
        <div class="ttd-block">
            <div class="ttd-tempat-tanggal">
                Bandung, {{ \Carbon\Carbon::parse($catatan->tanggal_catat)->format('d F Y') }}
            </div>
            <div class="ttd-garis"></div>
            <div class="ttd-nama">{{ $catatan->user->nama_user }}</div>
            <div class="ttd-jabatan">Guru Kelas {{ $catatan->siswa->kelas->nama_kelas }}</div>
        </div>
    </div>

    {{-- FOOTER DOKUMEN --}}
    <div class="paper-footer">
        <div class="paper-footer-kiri">
            Diterbitkan oleh Sistem Laskar Cilik<br>
            {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB
        </div>
        <div class="paper-footer-kanan">Hal. 1</div>
    </div>

</div>
