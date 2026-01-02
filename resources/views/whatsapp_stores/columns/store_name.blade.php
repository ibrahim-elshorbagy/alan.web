<div class="d-flex align-items-center">
    <a>
        <div class="image image-circle image-mini me-3">
            <img src="{{ $row->logo_url }}" alt="vCard">

        </div>
    </a>
    <div class="d-flex flex-column">
        @role(App\Models\Role::ROLE_ADMIN)
            <a class="text-decoration-none fs-6 text-info" href="{{ route('whatsapp.stores.edit', $row->id) }}">
                {{ $row->store_name }}
            </a>
        @else
            <span class="fs-6 text-info">{{ $row->store_name }}</span>
        @endrole
        @role(App\Models\Role::ROLE_ADMIN)
            <a class="fs-6 text-decoration-none mt-1 text-primary" href="{{ route('whatsapp.store.show', $row->url_alias) }}"
                target="_blank">
                {{ url(route('whatsapp.store.show', $row->url_alias)) }}
                <span style="
                    display:inline-block;
                    width:16px;
                    height:16px;
                    background-color: currentColor;
                    mask: url('{{ asset('images/new-tab.svg') }}') no-repeat center;
                    mask-size: cover;
                    vertical-align: middle;">
                </span>
            </a>
        @endrole
    </div>
</div>

