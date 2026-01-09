<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>QR Codes</title>
    <style>
        * { margin: 0; padding: 0; }
        @page { margin: 0; size: A4 portrait; }
        body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 0; }
        .page {
            width: 210mm;
            height: 297mm;
            position: relative;
            page-break-after: always;
            text-align: center;
            padding-top: 100px;
        }
        .page:last-child { page-break-after: avoid; }
        .qr-image {
            width: 350px;
            height: 350px;
            margin: 0 auto 50px;
        }
        .qr-image img {
            width: 100%;
            height: 100%;
        }
        .redeem-code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #000;
        }
    </style>
</head>
<body>
    @foreach ($qrCodes as $qr)
        <div class="page">
            <div class="qr-image">
                <img src="{{ $qr['qr_path'] }}" alt="QR Code">
            </div>
            <div class="redeem-code">{{ $qr['uri'] }}</div>
        </div>
    @endforeach
</body>
</html>
