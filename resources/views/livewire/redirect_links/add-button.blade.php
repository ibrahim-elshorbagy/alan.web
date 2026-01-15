<div class="d-flex flex-column gap-2">


  <div class="d-flex gap-2">
    @if ($this->hasSelected())
      <a type="button" class="btn btn-warning" wire:click="exportSelected">
        <i class="fas fa-file-export"></i> {{ __('messages.common.export_selected') }}
      </a>

      @hasrole('super_admin')
        <form action="{{ route('redirect-links.restore-selected') }}" method="POST" style="display: inline;"
          onsubmit="return confirm('{{ __('messages.redirect_links.restore_confirmation') }}')">
          @csrf
          <input type="hidden" name="ids" value="{{ implode(',', $this->selectedRows) }}">
          <button type="submit" class="btn btn-info">
            <i class="fas fa-undo"></i> {{ __('messages.redirect_links.restore_selected') }}
          </button>
        </form>
      @endhasrole
    @endif

    <a type="button" class="btn btn-success" href="{{ route('redirect-links.extract-all') }}">
      <i class="fas fa-download"></i> {{ __('messages.common.extract_all') }}
    </a>

    @hasrole('sales')
      <form action="{{ route('redirect-links.mark-all-as-received') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-success" data-bs-toggle="tooltip"
          title="تحديث جميع الروابط المخصصة لك كمستلمة"
          onclick="return confirm('هل أنت متأكد من أنك تريد تحديث جميع الروابط المخصصة لك كمستلمة؟ هذا الإجراء لا يمكن التراجع عنه.')">{{ __('messages.redirect_links.received_all') }}</button>
      </form>
    @endhasrole

    @if (!auth()->user()->hasRole('sales'))
      <a type="button" class="btn btn-primary" href="{{ route('redirect-links.create') }}">
        <i class="fas fa-plus"></i> {{ __('messages.common.add') }}
      </a>
    @endif
  </div>

</div>
