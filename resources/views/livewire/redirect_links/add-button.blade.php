<div class="d-flex gap-2">

  @if ($this->hasSelected())
    <a type="button" class="btn btn-warning" wire:click="exportSelected">
      <i class="fas fa-file-export"></i> {{ __('messages.common.export_selected') }}
    </a>
  @endif

  <a type="button" class="btn btn-success" href="{{ route('redirect-links.extract-all') }}">
    <i class="fas fa-download"></i> {{ __('messages.common.extract_all') }}
  </a>

  <a type="button" class="btn btn-primary" href="{{ route('redirect-links.create') }}">
    <i class="fas fa-plus"></i> {{ __('messages.common.add') }}
  </a>


</div>
