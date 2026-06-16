<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Catatan Perkembangan — {{ $catatan->siswa->nama_siswa }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 portrait;
            margin: 24mm 24mm;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.6;
            padding: 0;
            margin: 0;
        }

        /* HEADER */
        .header {
            width: 100%;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2c5282;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            padding: 5px 0;
        }

        .logo-cell {
            width: 80px;
            text-align: center;
        }

        .logo-cell img {
            width: 70px;
            height: 70px;
            display: block;
        }

        .school-info {
            text-align: center;
        }

        .school-name {
            font-size: 18px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .school-address {
            font-size: 10px;
            color: #666;
            line-height: 1.5;
        }

        .school-phone {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        .year-cell {
            width: 120px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }

        .year-value {
            font-size: 12px;
            font-weight: bold;
            color: #2c5282;
            margin-top: 3px;
        }

        /* TITLE */
        .document-title {
            text-align: center;
            margin: 25px 0 30px 0;
        }

        .document-title h1 {
            font-size: 16px;
            font-weight: bold;
            color: #1a365d;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        /* SECTIONS */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1a365d;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #4299e1;
            padding-bottom: 5px;
            margin-bottom: 12px;
        }

        /* IDENTITY TABLE */
        .identity-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .identity-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .label-cell {
            width: 180px;
            color: #555;
            font-weight: 500;
        }

        .separator-cell {
            width: 15px;
            text-align: center;
        }

        .value-cell {
            color: #2d3748;
            font-weight: 600;
        }

        /* ASPECT BOXES */
        .aspect-box {
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #4299e1;
            border-radius: 4px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .aspect-header {
            background-color: #ebf8ff;
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .aspect-title {
            font-size: 11px;
            font-weight: bold;
            color: #2c5282;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .aspect-content {
            padding: 12px;
            font-size: 11px;
            line-height: 1.8;
            color: #4a5568;
            text-align: justify;
        }

        /* PHOTO SECTION */
        .photo-section {
            margin-top: 25px;
            page-break-inside: avoid;
        }

        .photo-header {
            background-color: #4299e1;
            padding: 8px 12px;
            margin-bottom: 12px;
        }

        .photo-header span {
            font-size: 11px;
            font-weight: bold;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .photo-table {
            width: 100%;
            border-collapse: collapse;
        }

        .photo-table td {
            width: 32%;
            padding: 5px;
            vertical-align: top;
        }

        .photo-box {
            border: 1px solid #cbd5e0;
            padding: 4px;
            background-color: #f7fafc;
        }

        .photo-box img {
            width: 100%;
            height: auto;
            display: block;
            border: 1px solid #d1d5db;
        }

        .photo-caption {
            font-size: 9px;
            color: #4a5568;
            text-align: center;
            padding: 5px 3px;
            border-top: 1px solid #e2e8f0;
            margin-top: 4px;
            line-height: 1.4;
        }

        .photo-caption strong {
            display: block;
            margin-bottom: 2px;
            color: #2d3748;
        }

        .photo-caption em {
            font-size: 8px;
            color: #718096;
        }

        /* SIGNATURE */
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
        }

        .signature-table td {
            vertical-align: top;
        }

        .signature-cell {
            width: 45%;
            text-align: center;
            margin-left: auto;
        }

        .signature-location {
            margin-bottom: 80px;
            font-size: 11px;
        }

        .signature-text {
            margin-bottom: 8px;
            font-size: 11px;
        }

        .signature-line {
            border-top: 1px solid #2d3748;
            margin-top: 70px;
            padding-top: 5px;
        }

        .signature-name {
            font-weight: bold;
            font-size: 12px;
            color: #1a365d;
        }

        .signature-position {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }

        /* FOOTER */
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 8px;
            color: #a0aec0;
            text-align: center;
        }

        .footer table {
            width: 100%;
        }

        .footer td {
            padding: 3px 0;
        }

        .paper-doc-content {
            width: 100%;
            max-width: calc(100% - 28px);
            color: #1A1A2E;
            padding: 10px 14px 18px 14px;
            margin: 10px auto;
            box-sizing: border-box;
        }

        .kop {
            display: table;
            width: 100%;
            margin: 12px 0 18px;
            border-bottom: 2px solid #1A1A2E;
            padding-bottom: 8px;
        }

        .kop-logo {
            display: table-cell;
            width: 50px;
            vertical-align: middle;
            border-radius: 8px;
        }

        .kop-logo img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            display: block;
        }

        .kop-teks {
            display: table-cell;
            padding-left: 12px;
            vertical-align: middle;
        }

        .kop-right {
            display: table-cell;
            width: 120px;
            vertical-align: top;
            text-align: right;
            padding-left: 12px;
        }

        .kop-nama {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: #1A1A2E;
            margin-bottom: 3px;
        }

        .kop-alamat {
            font-size: 11px;
            color: #777;
            line-height: 1.6;
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
            width: 100%;
            background: linear-gradient(90deg, #C5C3F0 0%, #F9B8D0 40%, #FFD99A 70%, #A8EDDA 100%);
            border-radius: 3px;
            margin-top: 7px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .judul-dokumen {
            text-align: center;
            margin: 22px 0 20px;
        }

        .judul-dokumen h2 {
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #1A1A2E;
            margin-bottom: 4px;
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

        .label-col {
            width: 150px;
            color: #666;
            font-weight: 600;
            font-size: 12px;
        }

        .titik-col {
            width: 16px;
            color: #BBB;
        }

        .nilai-col {
            color: #1A1A2E;
        }

        .section-heading {
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
            display: block;
            margin-bottom: 24px;
            padding: 0 14px;
        }

        .aspek-item {
            border-left: 3px solid #C5C3F0;
            padding: 11px 14px;
            background: #FAFAFD;
            page-break-inside: avoid;
            margin-bottom: 10px;
        }

        .aspek-nama {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            width: 100%;
            margin-bottom: 24px;
            overflow: hidden;
            zoom: 1;
        }

        .foto-grid::after {
            content: '';
            display: table;
            clear: both;
        }

        .foto-item {
            float: left;
            width: 33.3333%;
            padding: 5px;
            vertical-align: top;
            border: 1px solid #E2E0F7;
            background-color: #f7fafc;
            page-break-inside: avoid;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .foto-item:nth-child(3n) {
            margin-right: 0;
        }

        .foto-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
            background: #ffffff;
        }

        .foto-caption {
            padding: 5px 8px;
            font-size: 10.5px;
            color: #888;
            border-top: 1px solid #E2E0F7;
            background: #FAFAFD;
            white-space: normal;
        }

        .foto-ket {
            display: block;
            font-size: 10px;
            color: #AAA;
            font-style: italic;
            margin-top: 4px;
        }

        .ttd-area {
            margin-top: 28px;
            width: 100%;
            page-break-inside: avoid;
            overflow: hidden;
        }

        .ttd-area::after {
            content: '';
            display: table;
            clear: both;
        }

        .ttd-block {
            width: 160px;
            float: right;
            text-align: center;
        }

        .ttd-tempat-tanggal {
            font-size: 11.5px;
            color: #555;
            margin-bottom: 44px;
        }

        .ttd-garis {
            border-top: 1px solid #1A1A2E;
            margin-bottom: 4px;
        }

        .ttd-nama {
            font-size: 12.5px;
            font-weight: 700;
            color: #1A1A2E;
        }

        .ttd-jabatan {
            font-size: 11px;
            color: #888;
            font-style: italic;
        }

        .paper-footer {
            margin-top: 32px;
            padding-top: 10px;
            border-top: 1px solid #E2E0F7;
            display: table;
            width: 100%;
            page-break-inside: avoid;
        }

        .paper-footer-kiri,
        .paper-footer-kanan {
            display: table-cell;
            vertical-align: top;
        }

        .paper-footer-kiri {
            font-size: 9.5px;
            color: #C0C0C8;
            line-height: 1.7;
            width: 70%;
        }

        .paper-footer-kanan {
            text-align: right;
            font-size: 9.5px;
            color: #C8C8D0;
            font-style: italic;
            width: 30%;
        }

        /* UTILITIES */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    @include('guru.catatan._catatan_content', ['isPdf' => true])
</body>

</html>
