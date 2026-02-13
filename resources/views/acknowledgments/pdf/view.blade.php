<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ __('messages.acknowledgment_report') }} - #{{ $acknowledgment->id }}</title>
  <style>
    /* ==================== Base Document Styles ==================== */
    @page {
      margin: 1.5cm;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 11pt;
      line-height: 1.3;
      color: #000000;
      background: #ffffff;
      direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
      padding: 0;
      margin: 0;
    }

    .document-container {
      max-width: 21cm;
      margin: 0 auto;
      padding: 1.5cm;
      background: white;
    }

    /* ==================== Compact Header ==================== */
    .document-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 2px solid #000000;
    }

    .logo-container {
      flex-shrink: 0;
      {{ app()->getLocale() == 'ar' ? 'margin-right' : 'margin-left' }}: 0;
    }

    .logo-container img {
      max-width: 80px;
      height: auto;
      display: block;
    }

    .company-info {
      flex: 1;
      text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
      {{ app()->getLocale() == 'ar' ? 'padding-left' : 'padding-right' }}: 15px;
      font-size: 9pt;
      line-height: 1.3;
    }

    .company-name {
      font-size: 12pt;
      font-weight: bold;
      margin-bottom: 3px;
    }

    .company-info>div {
      margin-bottom: 2px;
    }

    /* ==================== Document Title & Reference ==================== */
    .document-title-section {
      text-align: center;
      margin: 10px 0;
    }

    .document-title {
      font-size: 14pt;
      font-weight: bold;
      text-transform: uppercase;
      margin-bottom: 5px;
    }

    .document-meta {
      font-size: 10pt;
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .document-meta span {
      white-space: nowrap;
    }

    /* ==================== Compact Info Section ==================== */
    .recipient-info {
      margin: 15px 0;
      padding: 8px 12px;
      background: #f8f8f8;
      border: 1px solid #ddd;
      font-size: 10pt;
      line-height: 1.4;
    }

    .recipient-info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 8px 15px;
    }

    .info-item {
      display: flex;
      gap: 5px;
    }

    .info-item .label {
      font-weight: bold;
      flex-shrink: 0;
    }

    .info-item .value {
      flex: 1;
    }

    /* ==================== Compact Summary ==================== */
    .summary-compact {
      margin: 12px 0;
      padding: 8px 12px;
      background: #f0f0f0;
      border: 1px solid #ccc;
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 10px;
      font-size: 10pt;
    }

    .summary-item {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .summary-item .label {
      font-weight: bold;
    }

    .summary-item .value {
      font-weight: bold;
      font-size: 11pt;
    }

    /* ==================== Compact Data Table ==================== */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin: 12px 0;
      font-size: 10pt;
    }

    .data-table th,
    .data-table td {
      border: 1px solid #000000;
      padding: 6px 8px;
      text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
      vertical-align: middle;
    }

    .data-table th {
      background-color: #e8e8e8;
      font-weight: bold;
      text-align: center;
      font-size: 9pt;
    }

    .data-table td:first-child,
    .data-table th:first-child {
      text-align: center;
      width: 35px;
    }

    .data-table .serial-cell {
      font-family: 'Courier New', monospace;
      font-size: 9pt;
      font-weight: bold;
    }

    .data-table .amount-cell {
      text-align: center;
      font-weight: bold;
    }

    /* ==================== Compact Totals Below Table ==================== */
    .totals-compact {
      margin: 8px 0 15px auto;
      width: fit-content;
      {{ app()->getLocale() == 'ar' ? 'margin-left' : 'margin-right' }}: 0;
      border-top: 2px solid #000;
      padding-top: 6px;
      font-size: 10pt;
    }

    .totals-compact .total-row {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      margin-bottom: 4px;
    }

    .totals-compact .label {
      font-weight: bold;
    }

    .totals-compact .value {
      font-weight: bold;
      text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};
    }

    /* ==================== Declaration ==================== */
    .declaration-box {
      margin: 20px 0;
      padding: 12px;
      border: 1px solid #000000;
      background: #fafafa;
      font-size: 10pt;
    }

    .declaration-text {
      text-align: justify;
      line-height: 1.5;
      margin-bottom: 10px;
    }

    .notes-box {
      margin-top: 12px;
      padding-top: 10px;
      border-top: 1px solid #ccc;
    }

    .notes-label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
    }

    /* ==================== Compact Signature Section ==================== */
    .signature-section {
      margin-top: 25px;
      page-break-inside: avoid;
    }

    .signature-grid {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
    }

    .signature-cell {
      text-align: center;
      min-width: 150px;
    }

    .signature-line {
      width: 150px;
      border-bottom: 1.5px solid #000000;
      margin: 30px auto 8px auto;
    }

    .signature-label {
      font-weight: bold;
      font-size: 10pt;
      margin-bottom: 3px;
    }

    .signature-name {
      font-size: 10pt;
      margin-top: 3px;
    }

    /* ==================== Compact Footer ==================== */
    .document-footer {
      margin-top: 25px;
      padding-top: 10px;
      border-top: 2px solid #000000;
      font-size: 9pt;
      text-align: center;
      line-height: 1.4;
    }

    .document-footer .company-name-footer {
      font-weight: bold;
      margin-bottom: 3px;
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

      .summary-compact,
      .recipient-info,
      .declaration-box,
      .data-table th {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
      }

      .summary-compact {
        background-color: #f0f0f0 !important;
      }

      .recipient-info {
        background-color: #f8f8f8 !important;
      }

      .declaration-box {
        background-color: #fafafa !important;
      }

      .data-table th {
        background-color: #e8e8e8 !important;
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

    <!-- Compact Header: Logo Left, Company Info Right -->
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
    </div>

    <!-- Document Title & Meta Info -->
    <div class="document-title-section">
      <div class="document-title">{!! __('messages.acknowledgment_report') !!}</div>
      <div class="document-meta">
        <span><strong>{!! __('messages.acknowledgment_number') !!}:</strong> #{{ $acknowledgment->id }}</span>
        <span><strong>{{ __('messages.acknowledgment_date') }}:</strong>
          {{ $acknowledgment->created_at->format('d/m/Y') }}</span>
      </div>
    </div>

    <!-- Compact Recipient Info -->
    <div class="recipient-info">
      <div class="recipient-info-grid">
        <div class="info-item">
          <span class="label">{!! __('messages.common.name') !!}:</span>
          <span class="value">{!! $acknowledgment->salesUser->first_name . ' ' . $acknowledgment->salesUser->last_name !!}</span>
        </div>
        <div class="info-item">
          <span class="label">{!! __('messages.common.phone') !!}:</span>
          <span class="value">{{ $acknowledgment->salesUser->phone ?? '' }}</span>
        </div>
        <div class="info-item">
          <span class="label">{!! __('messages.common.email') !!}:</span>
          <span class="value">{{ $acknowledgment->salesUser->email }}</span>
        </div>
        <div class="info-item">
          <span class="label">{!! __('messages.created_by_admin') !!}:</span>
          <span class="value">{!! $acknowledgment->creator->first_name . ' ' . $acknowledgment->creator->last_name !!}</span>
        </div>
      </div>
    </div>

    <!-- Compact Summary -->
    <div class="summary-compact">
      <div class="summary-item">
        <span class="label">{!! __('messages.common.total') !!} {!! __('messages.common.items') !!}:</span>
        <span class="value">{{ $acknowledgment->total_count }}</span>
      </div>
      <div class="summary-item">
        <span class="label">{!! __('messages.receipts.total_regular_selling_price') !!}:</span>
        <span class="value">{{ currencyFormat($acknowledgment->total_price, 2) }}</span>
      </div>
      <div class="summary-item">
        <span class="label">{!! __('messages.receipts.total_selling_price_for_representative') !!}:</span>
        <span class="value">{{ currencyFormat($acknowledgment->total_sales_price, 2) }}</span>
      </div>
    </div>

    <!-- Card Details Table -->
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
            <td class="serial-cell">{{ $link->uri }}</td>
            <td style="text-align: center;">
              @if ($link->nfc)
                {!! $link->nfc->name !!}
              @else
                -
              @endif
            </td>
            <td class="amount-cell">{{ currencyFormat($link->price, 2) }}</td>
            <td class="amount-cell">{{ currencyFormat($link->sales_price, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Declaration -->
    <div class="declaration-box">
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

    <!-- Compact Signatures -->
    <div class="signature-section">
      <div class="signature-grid">
        <div class="signature-cell">
          <div class="signature-line"></div>
          <div class="signature-label">{!! __('messages.signature') !!}</div>
          <div class="signature-name">{!! $acknowledgment->salesUser->first_name . ' ' . $acknowledgment->salesUser->last_name !!}</div>
        </div>

        <div class="signature-cell">
          <div class="signature-line"></div>
          <div class="signature-label">{!! __('messages.common.date') !!}</div>
        </div>
      </div>
    </div>

    <!-- Compact Footer -->
    {{-- <div class="document-footer">
      <div class="company-name-footer">{!! getSuperAdminSettingValue('app_name') !!}</div>
      <div>{!! getSuperAdminSettingValue('address') !!}</div>
      <div>
        <a href="https://nfcjo.com/">www.nfcjo.com</a> |
        {{ getSuperAdminSettingValue('email') }}
        @if (getSuperAdminSettingValue('phone'))
          | +{{ getSuperAdminSettingValue('prefix_code') }}{{ getSuperAdminSettingValue('phone') }}
        @endif
      </div>
    </div> --}}

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
