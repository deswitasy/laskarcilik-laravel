<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'PDF')</title>
    <style>
                 
.paper-doc-content { width: 100%; }
.kop {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  padding-bottom: 14px;
  border-bottom: 2px solid #1A1A2E;
}

.kop-logo {
  width: 50px;
  height: 50px;
  object-fit: contain;
  flex-shrink: 0;
  border-radius: 8px;
}

.kop-teks { flex: 1; }

.kop-nama {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 16px;
  font-weight: 800;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #1A1A2E;
  margin-bottom: 3px;
}

.kop-alamat {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 11px;
  color: #777;
  line-height: 1.6;
}

.kop-right {
  text-align: right;
  font-family: 'Plus Jakarta Sans', sans-serif;
  flex-shrink: 0;
}

.kop-tahun-ajaran {
  font-size: 10.5px;
  color: #999;
  margin-bottom: 4px;
}

.kop-badge-ta {
  display: inline-block;
  padding: 3px 11px;
  background: #EEF0FF;
  color: #3A3570;
  border-radius: 20px;
  font-size: 11.5px;
  font-weight: 700;
}

.kop-divider-warna {
  height: 3px;
  background: linear-gradient(90deg,
    #C5C3F0 0%, #F9B8D0 40%, #FFD99A 70%, #A8EDDA 100%);
  border-radius: 3px;
  margin-top: 7px;
}

.judul-dokumen {
  text-align: center;
  margin: 22px 0 20px;
}

.judul-dokumen h2 {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 13.5px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #1A1A2E;
}

.judul-garis {
  width: 48px;
  height: 2px;
  background: #C5C3F0;
  border-radius: 2px;
  margin: 7px auto 0;
}

.tabel-identitas {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 24px;
  font-size: 13px;
}

.tabel-identitas td {
  padding: 4.5px 0;
  vertical-align: top;
  line-height: 1.6;
}

.tabel-identitas .label-col {
  width: 150px;
  color: #666;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 12px;
}

.tabel-identitas .titik-col {
  width: 16px;
  color: #BBB;
}

.tabel-identitas .nilai-col {
  color: #1A1A2E;
}

.section-heading {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.4px;
  color: #5B50C8;
  padding-bottom: 6px;
  border-bottom: 1px solid #E2E0F7;
  margin: 0 0 12px;
}

.aspek-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 24px;
}

.aspek-item {
  border-left: 3px solid #C5C3F0;
  padding: 11px 14px;
  background: #FAFAFD;
}

.aspek-nama {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .5px;
  color: #3A3570;
  margin-bottom: 6px;
}

.aspek-deskripsi {
  font-size: 13px;
  line-height: 1.85;
  color: #2D2D3A;
  white-space: pre-line;
}

.divider-dashed {
  border: none;
  border-top: 1px dashed #D8D8EA;
  margin: 22px 0;
}

.foto-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  margin-bottom: 24px;
}

.foto-item { border: 1px solid #E2E0F7; }

.foto-item img {
  width: 100%;
  height: 120px;
  object-fit: cover;
  display: block;
  cursor: zoom-in;
  transition: opacity .18s;
}

.foto-item img:hover { opacity: .88; }

.foto-caption {
  padding: 5px 8px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 10.5px;
  color: #888;
  border-top: 1px solid #E2E0F7;
  background: #FAFAFD;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.foto-ket {
  display: block;
  font-size: 10px;
  color: #AAA;
  font-style: italic;
}

.ttd-area {
  display: flex;
  justify-content: flex-end;
  margin-top: 28px;
}

.ttd-block { text-align: center; width: 160px; }

.ttd-tempat-tanggal {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 11.5px;
  color: #555;
  margin-bottom: 44px;
}

.ttd-garis {
  border-top: 1px solid #1A1A2E;
  margin-bottom: 4px;
}

.ttd-nama {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 12.5px;
  font-weight: 700;
  color: #1A1A2E;
}

.ttd-jabatan {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 11px;
  color: #888;
  font-style: italic;
}

.paper-footer {
  margin-top: 32px;
  padding-top: 10px;
  border-top: 1px solid #E2E0F7;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}

.paper-footer-kiri {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 9.5px;
  color: #C0C0C8;
  line-height: 1.7;
}

.paper-footer-kanan {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 9.5px;
  color: #C8C8D0;
  font-style: italic;
}}

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1A1A2E;
            line-height: 1.7;
            background: #ffffff;
        }

        .page-break {
            page-break-before: always;
        }

        .container {
            width: 100%;
            position: relative;
            padding-bottom: 60px;
        }

        /* ---- KOP SURAT ---- */
        .kop {
            width: 100%;
            border-bottom: 2px solid #1A1A2E;
            padding-bottom: 12px;
            margin-bottom: 0;
        }

        .kop-inner {
            width: 100%;
        }

        .kop-logo-cell {
            width: 58px;
            vertical-align: middle;
        }

        .kop-logo {
            width: 50px;
            height: 50px;
            border-radius: 8px;
        }

        .kop-text-cell {
            vertical-align: middle;
            padding-left: 12px;
        }

        .kop-nama {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1A1A2E;
            margin-bottom: 2px;
        }

        .kop-alamat {
            font-size: 10px;
            color: #777777;
            line-height: 1.5;
        }

        .kop-right-cell {
            vertical-align: middle;
            text-align: right;
            width: 110px;
        }

        .kop-ta-label {
            font-size: 9.5px;
            color: #999999;
            margin-bottom: 3px;
        }

        .kop-ta-badge {
            display: inline-block;
            background: #EEF0FF;
            color: #3A3570;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10.5px;
            font-weight: 700;
        }

        /* Garis pelangi pastel */
        .kop-divider {
            width: 100%;
            height: 3px;
            margin-top: 7px;
            /* DomPDF tidak support gradient — pakai border warna primer */
            background: #C5C3F0;
            border-radius: 3px;
        }

        /* ---- JUDUL DOKUMEN ---- */
        .judul-wrap {
            text-align: center;
            margin: 20px 0 18px;
        }

        .judul-teks {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #1A1A2E;
        }

        .judul-garis {
            width: 48px;
            height: 2px;
            background: #C5C3F0;
            margin: 7px auto 0;
            border-radius: 2px;
        }

        /* ---- TABEL IDENTITAS ---- */
        .tabel-identitas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
            font-size: 12px;
        }

        .tabel-identitas td {
            padding: 4px 0;
            vertical-align: top;
            line-height: 1.6;
        }

        .label-col {
            width: 150px;
            color: #666666;
            font-size: 11.5px;
        }

        .titik-col {
            width: 16px;
            color: #BBBBBB;
        }

        .nilai-col {
            color: #1A1A2E;
        }

        /* ---- SECTION HEADING ---- */
        .section-heading {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            color: #5B50C8;
            padding-bottom: 6px;
            border-bottom: 1px solid #E2E0F7;
            margin-bottom: 12px;
        }

        /* ---- ASPEK PERKEMBANGAN ---- */
        .aspek-item {
            border-left: 3px solid #C5C3F0;
            padding: 10px 14px;
            background: #FAFAFD;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .aspek-nama {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #3A3570;
            margin-bottom: 6px;
        }

        .aspek-deskripsi {
            font-size: 12px;
            line-height: 1.85;
            color: #2D2D3A;
            text-align: justify;
        }

        /* ---- DIVIDER ---- */
        .divider-dashed {
            border: none;
            border-top: 1px dashed #D8D8EA;
            margin: 20px 0;
        }

        /* ---- LAMPIRAN FOTO ---- */
        .lampiran-heading {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            color: #5B50C8;
            padding-bottom: 6px;
            border-bottom: 1px solid #E2E0F7;
            margin-bottom: 14px;
        }

        .lampiran-wrapper {
            page-break-inside: avoid;
            text-align: center;
            margin-bottom: 18px;
        }

        .foto-frame {
            display: inline-block;
            border: 1px solid #E2E0F7;
            padding: 10px;
            background: #FAFAFD;
            border-radius: 4px;
            margin: 0 auto;
        }

        .foto-frame img {
            max-width: 100%;
            max-height: 400px;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .foto-nama {
            margin-top: 8px;
            font-size: 10px;
            font-weight: 700;
            color: #1A1A2E;
            text-align: center;
        }

        .foto-keterangan {
            font-size: 9.5px;
            font-style: italic;
            color: #888888;
            text-align: center;
            margin-top: 3px;
        }

        /* ---- TANDA TANGAN ---- */
        .ttd-wrap {
            margin-top: 32px;
            text-align: right;
        }

        .ttd-block {
            display: inline-block;
            text-align: center;
            width: 160px;
        }

        .ttd-kota {
            font-size: 11.5px;
            color: #555555;
            margin-bottom: 44px;
        }

        .ttd-garis {
            border-top: 1px solid #1A1A2E;
            margin-bottom: 4px;
        }

        .ttd-nama {
            font-size: 12px;
            font-weight: 700;
            color: #1A1A2E;
        }

        .ttd-jabatan {
            font-size: 10.5px;
            font-style: italic;
            color: #888888;
        }

        /* ---- FOOTER DOKUMEN ---- */
        .doc-footer {
            margin-top: 28px;
            padding-top: 10px;
            border-top: 1px solid #E2E0F7;
        }

        .doc-footer-inner {
            width: 100%;
        }

        .doc-footer-kiri {
            font-size: 9px;
            color: #C0C0C8;
            line-height: 1.7;
            vertical-align: bottom;
        }

        .doc-footer-kanan {
            font-size: 9px;
            color: #C8C8D0;
            font-style: italic;
            text-align: right;
            vertical-align: bottom;
        }

        /* ---- WATERMARK TIMESTAMP ---- */
        .watermark-timestamp {
            position: fixed;
            bottom: -35px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #BBBBBB;
            font-style: italic;
        }
    </style>
</head>
<body>

@yield('content')

<div class="watermark-timestamp">
    Dicetak pada @yield('print-date', date('d F Y, H:i:s')) WIB
</div>

</body>
</html> -->