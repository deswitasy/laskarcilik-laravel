<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'PDF')</title>

    <style>
        @page {
            margin: 25px 30px 40px 30px; 
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.7;
            background: #f0f9ff;
            position: relative;
        }

        .page-break {
            page-break-before: always;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            position: relative;
            padding-bottom: 60px; 
        }

       
        .header {
            background: #2563eb;
            color: #fff;
            padding: 16px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0;
        }

        .header h1 {
            font-size: 20px;
            margin: 0 0 4px 0;
            font-weight: 700;
        }

        .header p {
            font-size: 13px;
            margin: 0;
        }

        
        .info-section {
            background: #ffffff;
            border: 1px solid #93c5fd;
            border-top: none;
            padding: 18px 20px;
            margin-bottom: 20px;
            border-radius: 0 0 8px 8px;
        }

        .info-row {
            display: inline-block;
            width: 48%;
            padding: 6px 0;
            font-size: 12px;
            vertical-align: top;
            color: #1e293b;
        }

        .info-row strong {
            display: inline-block;
            width: 130px;
            color: #1e40af;
            font-weight: 700;
        }

        .badge {
            display: inline-block;
            background: #3b82f6;
            color: #fff;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: bold;
        }

    
        .section-title {
            background: #1e40af;
            color: #fff;
            padding: 10px 16px;
            margin: 25px 0 14px 0;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
        }

     
        .penilaian-container {
            margin-top: 15px;
        }

        .penilaian-box {
            background: #ffffff;
            border: 1px solid #93c5fd;
            border-radius: 8px;
            padding: 16px 18px;
            margin-bottom: 14px;
            page-break-inside: avoid;
        }

        .penilaian-box-title {
            color: #1e40af;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 2px dashed #bfdbfe;
        }

        .penilaian-box-content {
            font-size: 12px;
            line-height: 1.8;
            color: #334155;
            text-align: justify;
        }

      
        .divider {
            border: none;
            border-top: 2px dashed #bfdbfe;
            margin: 20px 0;
        }

        .lampiran-wrapper {
            page-break-inside: avoid;
            text-align: center;
            margin-top: 25px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #93c5fd;
        }

        .lampiran-title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 3px solid #3b82f6;
            color: #1e40af;
        }

        .foto-frame {
            border: 2px solid #e5e7eb;
            padding: 14px;
            display: inline-block;
            background: #fff;
            border-radius: 8px;
            margin: 10px;
        }

        .foto-frame img {
            max-height: 480px;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            border-radius: 6px;
        }

        .foto-nama {
            margin-top: 10px;
            font-size: 11px;
            font-weight: bold;
            color: #1e293b;
        }

        .foto-keterangan {
            font-size: 10px;
            font-style: italic;
            color: #64748b;
            margin-top: 4px;
        }

       
        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            font-size: 12px;
            color: #1e293b;
        }

        .signature-location {
            margin-bottom: 8px;
            display: flex;
        }

        .signature-role {
            margin-bottom: 50px;
        }

        .signature-box strong {
            color: #1e40af;
        }

      
        .footer {
            margin-top: 50px;
            padding-top: 12px;
            border-top: 2px solid #bfdbfe;
            text-align: center;
            font-size: 11px;
            color: #1e40af;
            font-style: italic;
            font-weight: 600;
        }

        .watermark-timestamp {
            position: fixed;
            bottom: -35px; 
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            font-style: italic;
        }
    </style>
</head>
<body>

@yield('content')


 
<div class="watermark-timestamp">
    Dicetak pada @yield('print-date', date('d F Y, H:i:s')) WIB
     || TKIT KHALEEFA EL-RAHMAN
</div>

</body>
</html>