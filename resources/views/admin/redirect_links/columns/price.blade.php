<i class="bi bi-cpu fs-5 me-1" title="{{ $row->nfc->name ?? 'N/A' }}" data-bs-toggle="tooltip"></i>
{{ currencyFormat($row->price ?? 0, 0) }}
