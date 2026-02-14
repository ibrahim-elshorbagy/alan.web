<div class="d-flex flex-column gap-1 align-items-center">
  <span class="badge bg-info">#{{ str_pad($row->id, 4, '0', STR_PAD_LEFT) }}</span>
  @if (isset($acknowledgmentMap[$row->id]))
    <span class="badge bg-success" style="font-size: 0.7rem;">
      <i class="fas fa-file-contract"></i> {{ $acknowledgmentMap[$row->id] }}
    </span>
  @endif
</div>
