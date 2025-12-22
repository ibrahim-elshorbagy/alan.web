<a class="fs-6 text-decoration-none mt-1 text-primary" href="{{ route('whatsapp.store.show', $row->url_alias) }}"
    target="_blank">
    {{ url(route('whatsapp.store.show', $row->url_alias)) }}
</a>
<button class="btn px-2 text-primary fs-2 user-edit-btn copy-clipboard"
    data-id="{{ $row->id }}" title="{{'copy'}}">
    <i class="fa-regular fa-copy fs-2"></i>
</button>
<a class="fs-6 text-decoration-none mt-1 text-primary" href="{{ route('whatsapp.store.show', $row->url_alias) }}"
    target="_blank">
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
