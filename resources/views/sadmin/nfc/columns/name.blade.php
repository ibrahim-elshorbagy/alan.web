<div class="d-flex align-items-center">
  <div class="d-flex gap-2 me-3">
    <img src="{{ $row->nfc_image ?? asset('assets/img/nfc/card_default.png') }}" class="rounded"
      style="width: 50px; height: 50px; object-fit: cover;" alt="Front"
      onerror="this.onerror=null; this.src='{{ asset('assets/img/nfc/card_default.png') }}';">
    <img src="{{ $row->nfc_back_image ?? asset('assets/img/nfc/card_default.png') }}" class="rounded"
      style="width: 50px; height: 50px; object-fit: cover;" alt="Back"
      onerror="this.onerror=null; this.src='{{ asset('assets/img/nfc/card_default.png') }}';">
  </div>
  <span>{{ $row->name }}</span>
</div>
