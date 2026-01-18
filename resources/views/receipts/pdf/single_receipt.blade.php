<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إيصال - {{ $receipt->id }}</title>
  <style>
    body {
      font-family: 'DejaVu Sans', 'Arial Unicode MS', 'Noto Sans Arabic', sans-serif;
      margin: 0;
      padding: 20px;
      font-size: 12px;
      line-height: 1.4;
      direction: rtl;
      text-align: right;
    }

    .header {
      text-align: center;
      border-bottom: 2px solid #333;
      padding-bottom: 20px;
      margin-bottom: 30px;
    }

    .header h1 {
      margin: 0;
      color: #333;
      font-size: 24px;
    }

    .header p {
      margin: 5px 0;
      color: #666;
    }

    .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo img {
      max-width: 150px;
      height: auto;
    }

    .receipt-info {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 5px;
      margin-bottom: 30px;
      border: 1px solid #dee2e6;
    }

    .receipt-info h3 {
      margin-top: 0;
      color: #333;
      border-bottom: 1px solid #dee2e6;
      padding-bottom: 10px;
      text-align: right;
    }

    .info-grid {
      display: table;
      width: 100%;
      margin-bottom: 20px;
    }

    .info-row {
      display: table-row;
    }

    .info-cell {
      display: table-cell;
      padding: 8px;
      vertical-align: top;
    }

    .info-label {
      font-weight: bold;
      width: 30%;
      background-color: #e9ecef;
      text-align: right;
    }

    .info-value {
      width: 70%;
      text-align: left;
    }

    .amount-highlight {
      font-size: 18px;
      font-weight: bold;
      color: #198754;
      text-align: center;
      padding: 15px;
      background-color: #f8f9fa;
      border: 2px solid #dee2e6;
      border-radius: 5px;
      margin: 20px 0;
    }

    .footer {
      margin-top: 40px;
      text-align: center;
      font-size: 10px;
      color: #666;
      border-top: 1px solid #ddd;
      padding-top: 20px;
    }

    .signature-section {
      margin-top: 50px;
      display: table;
      width: 100%;
    }

    .signature-cell {
      display: table-cell;
      text-align: center;
      vertical-align: top;
      width: 50%;
    }

    .signature-line {
      border-bottom: 1px solid #333;
      width: 200px;
      margin: 40px auto 10px auto;
    }
  </style>
</head>

<body>
  <div class="header">
    <div class="logo">
      <img src="{{ getLogoUrl() }}" alt="شعار الموقع">
    </div>
    <h1>{!! processArabicText('إيصال دفع') !!}</h1>
    <p> #{{ $receipt->id }} {!! processArabicText('رقم الإيصال:') !!}</p>
    <p>{{ date('d/m/Y') }} {!! processArabicText('تاريخ الإنشاء:') !!} </p>
  </div>

  <div class="receipt-info">
    <h3>{!! processArabicText('تفاصيل الإيصال') !!}</h3>

    <div class="info-grid">
      <div class="info-row">
        <div class="info-cell info-value">{!! processArabicText($receipt->user->first_name) !!} {!! processArabicText($receipt->user->last_name) !!}</div>
        <div class="info-cell info-label">{!! processArabicText('المندوب:') !!}</div>
      </div>
      <div class="info-row">
        <div class="info-cell info-value">{{ $receipt->user->email }}</div>
        <div class="info-cell info-label">{!! processArabicText('البريد الإلكتروني:') !!}</div>
      </div>
      <div class="info-row">
        <div class="info-cell info-value">{{ $receipt->user->phone ?? '' }}{!! $receipt->user->phone ? '' : processArabicText('غير محدد') !!}</div>
        <div class="info-cell info-label">{!! processArabicText('رقم الهاتف:') !!}</div>
      </div>
      <div class="info-row">
        <div class="info-cell info-value">
          {{ $receipt->created_at->format('d/m/Y') }}
          {{ str_replace(['AM', 'PM'], ['ص', 'م'], $receipt->created_at->format('g:i A')) }}
        </div>
        <div class="info-cell info-label">{!! processArabicText('تاريخ الإيصال:') !!}</div>
      </div>
      <div class="info-row">
        <div class="info-cell info-value">
          {{ $receipt->received_at ? \Carbon\Carbon::parse($receipt->received_at)->format('d/m/Y') : processArabicText('غير محدد') }}
        </div>
        <div class="info-cell info-label">{!! processArabicText('تاريخ الاستلام:') !!}</div>
      </div>

      @if ($receipt->description)
        <div class="info-row">
          <div class="info-cell info-value">{!! processArabicText($receipt->description) !!}</div>
          <div class="info-cell info-label">{!! processArabicText('ملاحظات:') !!}</div>
        </div>
      @endif
      @if ($receipt->notes)
        <div class="info-row">
          <div class="info-cell info-value">{!! processArabicText($receipt->notes) !!}</div>
          <div class="info-cell info-label">{!! processArabicText('الملاحظات:') !!}</div>
        </div>
      @endif
    </div>
  </div>

  <div class="amount-highlight">
    ${{ number_format($receipt->amount, 2) }} {!! processArabicText('المبلغ المستلم') !!}
  </div>


</body>

</html>
