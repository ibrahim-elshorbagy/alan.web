<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ __('messages.acknowledgment_report') }} - #{{ $acknowledgment->id }}</title>
  <style>
    /* ==================== Base Document Styles ==================== */
    @page {
      margin: 2.5cm;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 12pt;
      line-height: 1.5;
      color: #000000;
      background: #ffffff;
      direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
      padding: 0;
      margin: 0;
    }

    .document-container {
      max-width: 21cm;
      margin: 0 auto;
      padding: 2cm;
      background: white;
    }

    /* ==================== Header ==================== */
    .document-header {
      text-align: center;
      margin-bottom: 40px;
      padding-bottom: 20px;
      border-bottom: 3px double #000000;
    }

    .logo-container {
      margin-bottom: 20px;
    }

    .logo-container img {
      max-width: 120px;
      height: auto;
    }

    .company-info {
      margin-bottom: 15px;
      font-size: 11pt;
      line-height: 1.4;
    }

    .company-name {
      font-size: 16pt;
      font-weight: bold;
      margin-bottom: 5px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .document-title {
      font-size: 18pt;
      font-weight: bold;
      text-transform: uppercase;
      margin: 20px 0 10px 0;
      letter-spacing: 2px;
    }

    .document-reference {
      font-size: 11pt;
      margin-top: 10px;
    }

    /* ==================== Information Sections ==================== */
    .section-heading {
      font-size: 13pt;
      font-weight: bold;
      text-transform: uppercase;
      margin: 30px 0 15px 0;
      padding-bottom: 5px;
      border-bottom: 2px solid #000000;
      text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
    }

    .info-table {
      width: 100%;
      margin-bottom: 25px;
      border-collapse: collapse;
    }

    .info-table td {
      padding: 8px 10px;
      vertical-align: top;
      text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
      line-height: 1.6;
    }

    .info-table .label {
      font-weight: bold;
      width: 35%;
    }

    .info-table .value {
      width: 65%;
    }

    .info-row {
      border-bottom: 1px solid #cccccc;
    }

    /* ==================== Data Table ==================== */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin: 25px 0;
      font-size: 11pt;
    }

    .data-table th,
    .data-table td {
      border: 1px solid #000000;
      padding: 10px;
      text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
      vertical-align: middle;
    }

    .data-table th {
      background-color: #f0f0f0;
      font-weight: bold;
      text-align: center;
      text-transform: uppercase;
      font-size: 10pt;
      letter-spacing: 0.5px;
    }

    .data-table td:first-child,
    .data-table th:first-child {
      text-align: center;
      width: 50px;
    }

    .data-table .amount-cell {
      text-align: center;
      font-weight: bold;
    }

    .data-table code {
      font-family: 'Courier New', monospace;
      font-size: 10pt;
      background: #f5f5f5;
      padding: 2px 5px;
    }

    /* ==================== Summary Box ==================== */
    .summary-box {
      margin: 30px 0;
      border: 2px solid #000000;
      padding: 20px;
      background: #fafafa;
    }

    .summary-table {
      width: 100%;
      border-collapse: collapse;
    }

    .summary-table td {
      padding: 10px;
      border-bottom: 1px solid #cccccc;
    }

    .summary-table .label {
      font-weight: bold;
      width: 70%;
      text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
    }

    .summary-table .value {
      width: 30%;
      text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};
      font-weight: bold;
      font-size: 13pt;
    }

    .summary-table tr:last-child td {
      border-bottom: none;
      padding-top: 15px;
      font-size: 14pt;
      border-top: 2px solid #000000;
    }

    /* ==================== Declaration ==================== */
    .declaration-box {
      margin: 35px 0;
      padding: 20px;
      border: 2px solid #000000;
      background: #ffffff;
    }

    .declaration-title {
      font-weight: bold;
      font-size: 12pt;
      margin-bottom: 15px;
      text-align: center;
      text-transform: uppercase;
    }

    .declaration-text {
      text-align: justify;
      line-height: 1.8;
      margin-bottom: 15px;
    }

    .notes-box {
      margin-top: 20px;
      padding-top: 15px;
      border-top: 1px solid #000000;
    }

    .notes-label {
      font-weight: bold;
      margin-bottom: 10px;
      display: block;
    }

    /* ==================== Signature Section ==================== */
    .signature-section {
      margin-top: 50px;
      page-break-inside: avoid;
    }

    .signature-grid {
      display: table;
      width: 100%;
      margin-top: 40px;
    }

    .signature-cell {
      display: table-cell;
      width: 50%;
      padding: 20px;
      vertical-align: top;
      text-align: center;
    }

    .signature-space {
      min-height: 60px;
      margin-bottom: 10px;
    }

    .signature-line {
      width: 200px;
      border-bottom: 2px solid #000000;
      margin: 50px auto 15px auto;
    }

    .signature-label {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .signature-name {
      font-size: 11pt;
      margin-top: 5px;
    }

    /* ==================== Footer ==================== */
    .document-footer {
      margin-top: 50px;
      padding-top: 20px;
      border-top: 3px double #000000;
      font-size: 10pt;
      text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
      line-height: 1.6;
    }

    .document-footer .company-name-footer {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .document-footer a {
      color: #000000;
      text-decoration: none;
    }

    /* ==================== Reference Section (Outside Document) ==================== */
    .reference-section {
      max-width: 21cm;
      margin: 30px auto;
      padding: 20px;
      background: #f8f9fa;
      border: 2px dashed #6c757d;
      border-radius: 8px;
      text-align: center;
    }

    .reference-title {
      font-family: Arial, sans-serif;
      font-size: 14pt;
      font-weight: bold;
      color: #495057;
      margin-bottom: 15px;
      text-transform: uppercase;
    }

    .reference-image {
      max-width: 400px;
      max-height: 200px;
      border: 2px solid #dee2e6;
      border-radius: 4px;
      padding: 10px;
      background: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .reference-note {
      font-family: Arial, sans-serif;
      font-size: 11pt;
      color: #6c757d;
      margin-top: 10px;
      font-style: italic;
    }

    /* ==================== Print Button ==================== */
    .print-button {
      position: fixed;
      top: 20px;
      {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 20px;
      z-index: 1000;
      background: #000000;
      color: white;
      border: none;
      padding: 12px 24px;
      cursor: pointer;
      font-size: 14px;
      font-family: Arial, sans-serif;
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .print-button:hover {
      background: #333333;
    }

    /* ==================== Print Styles ==================== */
    @media print {
      body {
        margin: 0;
        padding: 0;
      }

      .document-container {
        padding: 0;
        max-width: 100%;
      }

      .print-button,
      .reference-section {
        display: none !important;
      }

      .section-heading,
      .summary-box,
      .declaration-box,
      .signature-section {
        page-break-inside: avoid;
      }

      .data-table {
        page-break-inside: auto;
      }

      .data-table tr {
        page-break-inside: avoid;
        page-break-after: auto;
      }

      /* ✅ Force print backgrounds */
      .summary-box,
      .data-table th,
      .data-table code {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
      }

      /* Explicitly set backgrounds for print */
      .summary-box {
        background-color: #fafafa !important;
      }

      .data-table th {
        background-color: #f0f0f0 !important;
      }

      .data-table code {
        background-color: #f5f5f5 !important;
      }
    }

    @media screen {
      body {
        background: #e0e0e0;
        padding: 20px 0;
      }

      .document-container {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      }
    }
  </style>
</head>

<body>
  <!-- Print Button -->
  <button class="print-button" onclick="window.print()">
    {{ __('messages.print_acknowledgment') }}
  </button>

  <div class="document-container">

    <!-- Document Header -->
    <div class="document-header">
      <div class="logo-container">
        <img src="{{ getLogoUrl() }}">
      </div>

      <div class="company-info">
        <div class="company-name">{!! getSuperAdminSettingValue('app_name') !!}</div>
        <div>{!! getSuperAdminSettingValue('address') !!}</div>
        <div>
          {{ getSuperAdminSettingValue('email') }}
          @if (getSuperAdminSettingValue('phone'))
            | +{{ getSuperAdminSettingValue('prefix_code') }}{{ getSuperAdminSettingValue('phone') }}
          @endif
        </div>
      </div>

      <div class="document-title">{!! __('messages.acknowledgment_report') !!}</div>

      <div class="document-reference">
        {{ __('messages.acknowledgment_date') }}: {{ $acknowledgment->created_at->format('d/m/Y') }}
      </div>
    </div>

    <!-- Received By Section -->
    <h2 class="section-heading">{!! __('messages.received_by') !!}</h2>

    <table class="info-table">
      <tr class="info-row">
        <td class="label">{!! __('messages.common.name') !!}:</td>
        <td class="value">{!! $acknowledgment->salesUser->first_name . ' ' . $acknowledgment->salesUser->last_name !!}</td>
      </tr>
      <tr class="info-row">
        <td class="label">{!! __('messages.common.email') !!}:</td>
        <td class="value">{{ $acknowledgment->salesUser->email }}</td>
      </tr>
      <tr class="info-row">
        <td class="label">{!! __('messages.common.phone') !!}:</td>
        <td class="value">{{ $acknowledgment->salesUser->phone ?? '' }}</td>
      </tr>
      <tr class="info-row">
        <td class="label">{!! __('messages.created_by_admin') !!}:</td>
        <td class="value">{!! $acknowledgment->creator->first_name . ' ' . $acknowledgment->creator->last_name !!}</td>
      </tr>
    </table>

    <!-- Items Summary -->
    <div class="summary-box">
      <table class="summary-table">
        <tr>
          <td class="label">{!! __('messages.common.total') !!} {!! __('messages.common.items') !!}:</td>
          <td class="value">{{ $acknowledgment->total_count }}</td>
        </tr>
        <tr>
          <td class="label">{!! __('messages.receipts.total_regular_selling_price') !!}:</td>
          <td class="value">${{ number_format($acknowledgment->total_price, 2) }}</td>
        </tr>
        <tr>
          <td class="label">{!! __('messages.receipts.total_selling_price_for_representative') !!}:</td>
          <td class="value">${{ number_format($acknowledgment->total_sales_price, 2) }}</td>
        </tr>
      </table>
    </div>

    <!-- Card Details -->
    <h2 class="section-heading">{!! __('messages.card_details') !!}</h2>

    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>{!! __('messages.card_uri') !!}</th>
          <th>{!! __('messages.redirect_links.card_type') !!}</th>
          <th>{!! __('messages.common.price') !!}</th>
          <th>{!! __('messages.common.sales_price') !!}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($redirectLinks as $index => $link)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td><code>{{ $link->uri }}</code></td>
            <td style="text-align: center;">
              @if ($link->nfc)
                {!! $link->nfc->name !!}
              @else
              @endif
            </td>
            <td class="amount-cell">${{ number_format($link->price, 2) }}</td>
            <td class="amount-cell">${{ number_format($link->sales_price, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Declaration -->
    <div class="declaration-box">
      <div class="declaration-title">{!! __('messages.common.declaration') !!}</div>
      <div class="declaration-text">
        {!! __('messages.acknowledgment_declaration_text') !!}
      </div>

      @if ($acknowledgment->notes)
        <div class="notes-box">
          <span class="notes-label">{!! __('messages.common.notes') !!}:</span>
          <div>{!! $acknowledgment->notes !!}</div>
        </div>
      @endif
    </div>

    <!-- Signatures -->
    <div class="signature-section">
      <div class="signature-grid">
        <div class="signature-cell">
          <div class="signature-space"></div>
          <div class="signature-line"></div>
          <div class="signature-label">{!! __('messages.signature') !!}</div>
          <div class="signature-name">{!! $acknowledgment->salesUser->first_name . ' ' . $acknowledgment->salesUser->last_name !!}</div>
        </div>

        <div class="signature-cell">
          <div class="signature-space"></div>
          <div class="signature-line"></div>
          <div class="signature-label">{!! __('messages.common.date') !!}</div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="document-footer">
      <div class="company-name-footer">{!! getSuperAdminSettingValue('app_name') !!}</div>
      <div>{!! getSuperAdminSettingValue('address') !!}</div>
      <div>
        <a href="https://nfcjo.com/">www.nfcjo.com</a> |
        {{ getSuperAdminSettingValue('email') }}
        @if (getSuperAdminSettingValue('phone'))
          | +{{ getSuperAdminSettingValue('prefix_code') }}{{ getSuperAdminSettingValue('phone') }}
        @endif
      </div>
    </div>

  </div>

  <!-- Reference Section (Outside Document - Won't Print) -->
  @if ($acknowledgment->signature_file)
    <div class="reference-section">
      <div class="reference-title">{{ __('messages.signature') }} ({{ __('messages.common.current') }})</div>
      <img src="{{ $acknowledgment->signature_url }}" alt="Signature Reference" class="reference-image">
      <p class="reference-note">{{ __('messages.cover_image.reference_only') }}</p>
    </div>
  @endif

</body>

</html>
