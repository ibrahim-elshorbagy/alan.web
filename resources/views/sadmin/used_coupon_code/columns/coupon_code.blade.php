@php
    $couponCodeData = json_decode(json_encode($row['coupon_code_meta']), true);
    $code = $couponCodeData['couponCode'] ?? null;
@endphp

@if ($code)
    {{ $code }}
@else
@endif
