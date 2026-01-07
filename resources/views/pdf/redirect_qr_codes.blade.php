<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>QR Codes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        @page {
            margin: 0;
            size: A4 portrait;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 210mm;
            height: 297mm;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            page-break-after: always;
        }
        .page:last-child {
            page-break-after: avoid;
        }
        .qr-image {
            width: 350px;
            height: 350px;
        }
        .redeem-code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #000;
            margin-top: 50px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
@foreach($qrCodes as $qr)
    <div class="page">
        <img src="{{ $qr['qr_path'] }}" class="qr-image" alt="QR Code">
        <div class="redeem-code">{{ $qr['redeem_code'] }}</div>
    </div>
@endforeach
</body>
</html>
