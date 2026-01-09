<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>QR Codes</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
    @foreach ($qrCodes as $qr)
        <div style="width: 210mm; height: 297mm; page-break-after: always; text-align: center; padding-top: 100px;">
            <div style="width: 350px; height: 350px; margin: 0 auto 50px;">
                <img src="{{ $qr['image_data'] }}" style="width: 350px; height: 350px;" />
            </div>
            <div style="font-size: 36px; font-weight: bold; letter-spacing: 4px;">{{ $qr['uri'] }}</div>
        </div>
    @endforeach
</body>
</html>
