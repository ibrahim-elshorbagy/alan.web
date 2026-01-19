<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تقرير إيصالات المندوب - {{ $user->first_name }} {{ $user->last_name }}</title>
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

    .salesman-info {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 5px;
      margin-bottom: 30px;
      border: 1px solid #dee2e6;
    }

    .salesman-info h3 {
      margin-top: 0;
      color: #333;
      border-bottom: 1px solid #dee2e6;
      padding-bottom: 10px;
      text-align: right;
    }

    .analytics {
      display: table;
      width: 100%;
      margin-bottom: 30px;
      border-collapse: collapse;
    }

    .analytics-row {
      display: table-row;
    }

    .analytics-cell {
      display: table-cell;
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
      vertical-align: middle;
    }

    .analytics-label {
      background-color: #f8f9fa;
      font-weight: bold;
      width: 25%;
    }

    .analytics-value {
      font-size: 16px;
      font-weight: bold;
    }

    .analytics-value.total-sold {
      color: #6f42c1;
    }

    .analytics-value.sold-amount {
      color: #198754;
    }

    .analytics-value.total-received {
      color: #0d6efd;
    }

    .analytics-value.balance {
      color: #dc3545;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .table th,
    .table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: right;
    }

    .table th {
      background-color: #f8f9fa;
      font-weight: bold;
      text-align: center;
    }

    .table tbody tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    .table tbody tr:hover {
      background-color: #e9ecef;
    }

    .amount {
      text-align: right;
      font-weight: bold;
    }

    .date {
      text-align: center;
    }

    .footer {
      margin-top: 40px;
      text-align: center;
      font-size: 10px;
      color: #666;
      border-top: 1px solid #ddd;
      padding-top: 20px;
    }

    .balance-positive {
      color: #dc3545;
    }

    .balance-negative {
      color: #198754;
    }
  </style>
</head>

<body>
  <div class="header">
    <div class="logo">
      <img src="{{ getLogoUrl() }}" alt="شعار الموقع">
    </div>
    <h1>{!! processArabicText('تقرير إيصالات المندوب') !!}</h1>
    <p> {{ date('d/m/Y') }}{!! processArabicText('تاريخ الإنشاء:') !!}</p>
    <p>{!! processArabicText('الفترة الزمنية: كل الفترات') !!}</p>
  </div>

  <div class="salesman-info">
    <h3>{!! processArabicText('معلومات المندوب') !!}</h3>
    <p> {!! processArabicText($user->last_name) !!} {!! processArabicText($user->first_name) !!}<strong>{!! processArabicText('الاسم:') !!}</strong> </p>
    <p> {{ $user->email }}<strong>{!! processArabicText('البريد الإلكتروني:') !!}</strong></p>
    <p> {{ $user->phone ?? '' }}{!! $user->phone ? '' : processArabicText('غير محدد') !!}<strong>{!! processArabicText('رقم الهاتف:') !!}</strong></p>
  </div>

  <div class="analytics">
    <div class="analytics-row">
      <div class="analytics-cell analytics-value total-sold">{{ $totalSold }}</div>
      <div class="analytics-cell analytics-label">{!! processArabicText('إجمالي البطاقات المباعة') !!}</div>
      <div class="analytics-cell analytics-value sold-amount">${{ number_format($soldAmount, 2) }}</div>
      <div class="analytics-cell analytics-label">{!! processArabicText('مبلغ المبيعات') !!}</div>
    </div>
    <div class="analytics-row">
      <div class="analytics-cell analytics-value total-received">${{ number_format($totalReceived, 2) }}</div>
      <div class="analytics-cell analytics-label">{!! processArabicText('إجمالي المستلم') !!}</div>
      <div class="analytics-cell analytics-value balance">
        ${{ number_format($balance, 2) }}
        @if ($balance >= 0)
          <span class="balance-positive">({!! processArabicText('مدين') !!})</span>
        @else
          <span class="balance-negative">({!! processArabicText('دائن') !!})</span>
        @endif
      </div>
      <div class="analytics-cell analytics-label">{!! processArabicText('الرصيد') !!}</div>
    </div>
  </div>

  <h2 style="text-align: center; margin: 30px 0 20px 0; color: #333;">{!! processArabicText('تفاصيل الإيصالات') !!}</h2>

  @if ($receipts->count() > 0)
    <table class="table">
      <thead>
        <tr>
          <th style="width: 30%;">{!! processArabicText('ملاحظات') !!}</th>
          <th style="width: 15%;">{!! processArabicText('التاريخ') !!}</th>
          <th style="width: 20%;">{!! processArabicText('المبلغ') !!}</th>
          <th style="width: 10%;">#</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($receipts as $index => $receipt)
          <tr>
            <td>
              @if ($receipt->description)
                {!! processArabicText($receipt->description) !!}
              @else
                -
              @endif
            </td>
            <td class="date">
              @if ($receipt->received_at)
                {{ \Carbon\Carbon::parse($receipt->received_at)->format('d/m/Y') }}
                {{ str_replace(['AM', 'PM'], ['ص', 'م'], \Carbon\Carbon::parse($receipt->received_at)->format('g:i A')) }}
              @else
                {!! processArabicText('غير محدد') !!}
              @endif
            </td>
            <td class="amount">${{ number_format($receipt->amount, 2) }}</td>
            <td style="text-align: center;">{{ $index + 1 }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center; font-style: italic; color: #666; margin: 40px 0;">{!! processArabicText('لا توجد إيصالات لهذا المندوب.') !!}</p>
  @endif

  <div class="footer">
    <p>{{ getSuperAdminSettingValue('email') }}</p>
    <p> {!! processArabicText(getSuperAdminSettingValue('app_name')) !!}</p>
    <p>
      {{ getSuperAdminSettingValue('phone') ? '+' . getSuperAdminSettingValue('prefix_code') . getSuperAdminSettingValue('phone') : processArabicText('غير محدد') }}
    </p>
    <p> {!! processArabicText(getSuperAdminSettingValue('address')) !!}</p>
    <p><a href="https://nfcjo.com/">https://nfcjo.com/</a></p>
  </div>
</body>

</html>
