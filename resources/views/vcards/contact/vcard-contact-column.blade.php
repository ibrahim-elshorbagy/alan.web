@if($row->region_code && $row->phone)
    <span>{{ '+'. $row->region_code ?? '' }} {{ $row->phone }}</span>
@elseif ($row->phone)
    <span>{{ $row->phone }}</span>
@else
    <span>-</span>
@endif
