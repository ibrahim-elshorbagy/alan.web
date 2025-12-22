<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <title>{{__('messages.nfc.nfc_order_invoice')}}</title>

    <style>
        td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>

    <div style="text-align: center;">
        <img src="{{ getAppLogo() }}" width="80px" alt="Logo">
        <h2>{{ $appName }}</h2>
    </div>

<table style="width: 100%; margin-top: 20px; border-collapse: collapse; border: 0px solid #fff; table-layout: fixed;">
    <tr>
        <!-- User Details -->
        <td style="width: 50%; vertical-align: top; padding-right: 10px; border:0px solid #fff;border-right:1px solid lightgrey">
            <h4 style="margin-bottom: 10px;"><strong>{{ __('messages.user.user_details') }}</strong></h4>
            <table style="width: 100%; border: none; border-collapse: collapse;">
                <tr>
                    <td style="border: none; text-align: left; word-break: break-word;font-size:16px;"><span>{{ __('messages.common.name') }}:</span></td>
                    <td style="border: none; text-align: left; word-break: break-word;font-size:16px;color:gray;">{{ $nfcOrder->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="border: none; text-align: left;font-size:16px;"><span>{{ __('messages.common.email') }}:</span></td>
                    <td style="border: none; text-align: left; word-break: break-word;font-size:16px;color:gray;">{{ $nfcOrder->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="border: none; text-align: left;font-size:16px;"><span>{{ __('messages.common.phone') }}:</span></td>
                    <td style="border: none; text-align: left;font-size:16px;color:gray;">{{ $nfcOrder->region_code ? '+' . $nfcOrder->region_code . ' ' : '' }}{{ $nfcOrder->phone }}</td>
                </tr>
                <tr>
                    <td style="border: none; text-align: left;font-size:16px;"><span>{{ __('messages.user.address') }}:</span></td>
                    <td style="border: none; text-align: left; word-break: break-word;font-size:16px;color:gray;">{{ $nfcOrder->address ?? 'N/A' }}</td>
                </tr>
            </table>
        </td>

        <!-- Payment Details -->
        <td style="width: 50%; vertical-align: top; padding-left: 10px;border:0px solid #fff">
            <h4 style="margin-bottom: 10px;"><strong>{{ __('messages.nfc.payment_details') }}</strong></h4>
            <table style="width: 100%; border: none; border-collapse: collapse;">
                <tr>
                    <td style="border: none; text-align: left;font-size:16px;"><span>{{ __('messages.nfc.paid_amount') }}:</span></td>
                    <td style="border: none; text-align: left;font-size:16px;color:gray;">{{ $nfcOrder->nfcTransaction->amount ?? '0' }}</td>
                </tr>
                <tr>
                    <td style="border: none; text-align: left;font-size:16px;"><span>{{ __('messages.nfc.paid_on') }}:</span></td>
                    <td style="border: none; text-align: left;font-size:16px;color:gray;">{{ $nfcOrder->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="border: none; text-align: left;font-size:16px;"><span>{{ __('messages.payment_type') }}:</span></td>
                    <td style="border: none; text-align: left;font-size:16px;color:gray;"> {{ $nfcOrder->nfcTransaction
                        ? ucfirst(\App\Models\NfcOrders::PAYMENT_TYPE_ARR[$nfcOrder->nfcTransaction->type] ?? 'N/A')
                        : __('messages.placeholder.payment_failed') }}</td>
                </tr>
                <tr>
                    <td style="border: none; text-align: left;font-size:16px;"><span>{{ __('messages.nfc.transaction_id') }}:</span></td>
                    <td style="border: none; text-align: left; word-break: break-word;font-size:16px;color:gray;">{{ $nfcOrder->nfcTransaction->transaction_id ?? 'N/A' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

    {{-- Card Details --}}
    <div style="width:100%; background:#fff; border-radius:10px; margin:30px auto; box-shadow:0 2px 12px rgba(40,60,90,0.07);">
      <h4 style="padding:28px 28px 12px; margin:0; font-weight:800; font-size:20px; color:#283548;">
        {{ __('messages.whatsapp_stores.order_details') }}
      </h4>
      <table style="width:100%; border-collapse:collapse; margin-top:10px;">
        <thead>
          <tr style="background:#f0f4fa;">
            <th align="left" style="padding:14px 28px; font-weight:700; font-size:15px; color:#153563; border:none;">{{ __('messages.nfc.item') }}</th>
            <th align="right" style="padding:14px 28px; font-weight:700; font-size:15px; color:#153563; border:none;">{{ __('messages.common.price') }}</th>
            <th align="right" style="padding:14px 28px; font-weight:700; font-size:15px; color:#153563; border:none;">{{ __('messages.whatsapp_stores_templates.quantity') }}</th>
            <th align="right" style="padding:14px 28px; font-weight:700; font-size:15px; color:#153563; border:none;">{{ __('messages.nfc.total') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr style="background:#fff;">
            <td style="padding:10px 28px; border:none;">
              <strong style="font-size:15px; color:#283548;">{{ $nfcOrder->nfcCard->name ?? 'N/A' }}</strong>
            </td>
            <td align="right" style="padding:10px 28px; border:none; color:#2d3436;">
              {{ $nfcOrder->nfcCard->price ?? 0 }}
            </td>
            <td align="right" style="padding:10px 28px; border:none; color:#2d3436;">
              {{ $nfcOrder->quantity ?? 1 }}
            </td>
            <td align="right" style="padding:10px 28px; border:none; color:#2d3436;">
              {{ number_format($nfcOrder->nfcCard->price * $nfcOrder->quantity, 2) ?? 0 }}
            </td>
          </tr>
        </tbody>
      </table>
      <div style="height:12px;"></div>
      <table style="width:100%; border-collapse:collapse;">
        <tbody>
          <tr>
            <td style="padding:8px 28px; color:#7b8a99; font-size:14px; border:none;">{{ __('messages.nfc.subtotal') }}</td>
            <td align="right" style="padding:8px 28px; color:#283548; border:none; font-size:14px;">
              {{ number_format($nfcOrder->nfcCard->price * $nfcOrder->quantity, 2) }}
            </td>
          </tr>
          <tr>
            <td style="padding:8px 28px; color:#7b8a99; font-size:14px; border:none;">
              {{ __('messages.nfc.tax') }} <span style="font-size:11px;">({{ $nfcOrder->nfcTransaction->tax ?? 0 }}%)</span>
            </td>
            <td align="right" style="padding:8px 28px; color:#283548; border:none; font-size:14px;">
              {{ number_format(($nfcOrder->nfcCard->price * $nfcOrder->quantity * ($nfcOrder->nfcTransaction->tax ?? 0)) / 100, 2) }}
            </td>
          </tr>
          <tr>
            <td style="padding:13px 28px; font-weight:700; color:#153563; border:none; font-size:16px;">
              {{ __('messages.whatsapp_stores.grand_total') }}
            </td>
            <td align="right" style="padding:13px 28px; font-weight:700; color:#153563; border:none; font-size:16px;">
              {{ $nfcOrder->nfcTransaction->amount ?? '0' }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</body>
</html>
