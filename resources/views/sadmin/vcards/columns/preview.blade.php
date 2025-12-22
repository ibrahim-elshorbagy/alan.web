@php
    $url = route('vcard.show', ['alias' => $row->url_alias]);
    $shortUrl = \Illuminate\Support\Str::limit($url, 50, '...');
@endphp
@if ($row->status == 1)
<a href="{{ route('vcard.show', ['alias' => $row->url_alias]) }}" id="vcardUrl{{ $row->id }}"
   target="_blank" class="text-decoration-none fs-6 text-primary">{{ $shortUrl }}</a>
<button class="btn px-2 text-primary fs-2 user-edit-btn copy-clipboard"
        data-id="{{ $row->id }}" title="{{'copy'}}">
    <i class="fa-regular fa-copy fs-2"></i>
</button>
<a href="{{ route('vcard.show', ['alias' => $row->url_alias]) }}" id="vcardUrl{{ $row->id }}"
   target="_blank" class="text-decoration-none fs-6 text-primary">
    <span style="
        display:inline-block;
        width:16px;
        height:16px;
        background-color: currentColor;
        mask: url('{{ asset('images/new-tab.svg') }}') no-repeat center;
        mask-size: cover;
        -webkit-mask: url('{{ asset('images/new-tab.svg') }}') no-repeat center;
        -webkit-mask-size: cover;
        filter: drop-shadow(0 0 1px currentColor);
        vertical-align: middle;">
    </span>
</a>
@else
<span id="vcardUrl{{$row->id}}" target="_blank"> {{ route('vcard.show', ['alias' => $row->url_alias]) }} </span>
@endif
