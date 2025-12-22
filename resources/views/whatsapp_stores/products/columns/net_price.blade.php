<span>
    @if ($row->net_price)
        {{ currencyFormat($row->net_price, 0, $row->currency->currency_code) }}
    @else
        N/A
    @endif

</span>
