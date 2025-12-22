<div style="display: flex; align-items: center; gap: 10px;">
    <div class="card" style="width: 4rem; height: 4rem;">
        <img src="{{ $row->nfc_image ?? asset('assets/img/nfc/card_default.png') }}"
            class="card-img-top rounded rounded-3 overflow-hidden" alt="vCard" height="120"
            onerror="this.onerror=null; this.src='{{ asset('assets/img/nfc/card_default.png') }}';">
    </div>
    <span>{{ $row->name }}</span>
</div>
