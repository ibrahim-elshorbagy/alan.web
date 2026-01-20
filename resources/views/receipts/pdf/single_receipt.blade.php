<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>سند قبض - {{ $receipt->id }}</title>
  <style>
    body {
      font-family: 'Noto Sans Arabic','Arial Unicode MS',sans-serif,'Segoe UI Light';
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
      text-align: right;
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

    .balance-highlight {
      font-size: 16px;
      font-weight: bold;
      color: #333;
      text-align: center;
      padding: 12px;
      background-color: #fff3cd;
      border: 2px solid #ffeaa7;
      border-radius: 5px;
      margin: 15px 0;
    }

    .balance-positive {
      color: #dc3545;
    }

    .balance-negative {
      color: #198754;
    }

    .footer {
      margin-top: 40px;
      text-align: right;
      direction:rtl;
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
    <h1>{!! processArabicText('سند قبض') !!}</h1>
    <p> #{{ $receipt->id }} {!! processArabicText('رقم السند:') !!}</p>
    <p>{{ date('d/m/Y') }} {!! processArabicText('التاريخ:') !!} </p>
  </div>

  <div class="receipt-info">
    <h3>{!! processArabicText('البيان') !!}</h3>

    <div class="info-grid">
      <div class="info-row">
        <div class="info-cell">{!! processArabicText($receipt->user->last_name) !!} {!! processArabicText($receipt->user->first_name) !!} <strong>{!! processArabicText('المندوب:') !!}</strong>
        </div>
      </div>
      <div class="info-row">
        <div class="info-cell">{{ $receipt->user->email }} <strong>{!! processArabicText('البريد الإلكتروني:') !!}</strong></div>
      </div>
      <div class="info-row">
        <div class="info-cell">{{ $receipt->user->phone ?? '' }}{!! $receipt->user->phone ? '' : processArabicText('غير محدد') !!}
          <strong>{!! processArabicText('رقم الهاتف:') !!}</strong>
        </div>
      </div>
      <div class="info-row">
        <div class="info-cell">
          {{ $receipt->created_at->format('d/m/Y') }}
          {{ str_replace(['AM', 'PM'], ['ص', 'م'], $receipt->created_at->format('g:i A')) }}
          <strong>{!! processArabicText('التاريخ:') !!}</strong>
        </div>
      </div>
      <div class="info-row">
        <div class="info-cell">
          {{ $receipt->received_at ? \Carbon\Carbon::parse($receipt->received_at)->format('d/m/Y') : processArabicText('غير محدد') }}
          <strong>{!! processArabicText('تاريخ الاستلام:') !!}</strong>
        </div>
      </div>

      @if ($receipt->description)
        <div class="info-row">
          <div class="info-cell">{!! processArabicText($receipt->description) !!} <strong>{!! processArabicText('ملاحظات:') !!}</strong></div>
        </div>
      @endif
      @if ($receipt->notes)
        <div class="info-row">
          <div class="info-cell">{!! processArabicText($receipt->notes) !!} <strong>{!! processArabicText('الملاحظات:') !!}</strong></div>
        </div>
      @endif
    </div>
  </div>

  <div class="amount-highlight">
    ${{ number_format($receipt->amount, 2) }} {!! processArabicText('المبلغ') !!}
  </div>

  <div class="balance-highlight">
    ${{ number_format($balance, 2) }}
    @if ($balance >= 0)
      <span class="balance-positive">({!! processArabicText('مدين') !!})</span>
    @else
      <span class="balance-negative">({!! processArabicText('دائن') !!})</span>
    @endif
    {!! processArabicText('الرصيد الحالي') !!}
  </div>
  
  <div class="footer">
    <p><b> {!! processArabicText(getSuperAdminSettingValue('app_name')) !!}</b></p>
    <p> {!! processArabicText(getSuperAdminSettingValue('address')) !!}</p>
    <p><a href="https://nfcjo.com/">www.nfcjo.com</a> | {{ getSuperAdminSettingValue('email') }} | {{ getSuperAdminSettingValue('phone') ? '+' . getSuperAdminSettingValue('prefix_code') . getSuperAdminSettingValue('phone') : processArabicText('غير محدد') }}</p>
  </div>

</body>

</html>
