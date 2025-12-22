@if ($row->custom_select == 1)
    {{ currencyFormat($row->planCustomFields[0]->custom_vcard_price, 0, $row->currency->currency_code) }}
@else
    <div>
        {{ currencyFormat($row->price, 0, $row->currency->currency_code) }}
    </div>
@endif
