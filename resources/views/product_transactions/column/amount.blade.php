{{ $row->currency->currency_icon }}{{ getSuperAdminSettingValue('hide_decimal_values') == 1 ? number_format($row->amount, 0) : number_format($row->amount, 2) }}
