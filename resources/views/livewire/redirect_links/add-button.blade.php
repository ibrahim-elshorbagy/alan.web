<div class="d-flex flex-column gap-3">
  {{-- Filters Row --}}
  <div class="d-flex flex-wrap gap-2 align-items-end">
    
    {{-- Assigned To Filter (only for non-sales users) --}}
    @if (!auth()->user()->hasRole('sales'))
      <div class="filter-item">
        <label class="form-label small mb-1">{{ __('messages.redirect_links.assigned_to') }}</label>
        <select class="form-control form-select" wire:model.live="assignedFilter">
          <option value="">{{ __('messages.common.all') }}</option>
          @foreach (\App\Models\User::role('sales')->get() as $salesUser)
            <option value="{{ $salesUser->id }}">{{ $salesUser->first_name }} {{ $salesUser->last_name }}</option>
          @endforeach
        </select>
      </div>
    @endif

    {{-- Status Filter --}}
    <div class="filter-item">
      <label class="form-label small mb-1">{{ __('messages.redirect_links.status') }}</label>
      <select class="form-control form-select" wire:model.live="statusFilter">
        <option value="">{{ __('messages.common.all') }}</option>
        <option value="0">{{ __('messages.redirect_links.not_redeemed') }}</option>
        <option value="1">{{ __('messages.redirect_links.redeemed') }}</option>
        <option value="2">{{ __('messages.redirect_links.rejected') }}</option>
      </select>
    </div>

    {{-- Redirect Type Filter --}}
    <div class="filter-item">
      <label class="form-label small mb-1">{{ __('messages.redirect_links.redirect_type') }}</label>
      <select class="form-control form-select" wire:model.live="redirectTypeFilter">
        <option value="">{{ __('messages.common.all') }}</option>
        @foreach (\App\Enums\RedirectLinkTypeEnum::cases() as $type)
          <option value="{{ $type->value }}">{{ $type->label() }}</option>
        @endforeach
      </select>
    </div>

    {{-- Card Type Filter --}}
    <div class="filter-item">
      <label class="form-label small mb-1">{{ __('messages.redirect_links.card_type') }}</label>
      <select class="form-control form-select" wire:model.live="cardTypeFilter">
        <option value="">{{ __('messages.common.all') }}</option>
        @foreach (\App\Models\Nfc::all() as $nfc)
          <option value="{{ $nfc->id }}">{{ $nfc->name }}</option>
        @endforeach
      </select>
    </div>


  </div>

  {{-- Buttons Row --}}
  <div class="d-flex flex-wrap gap-2">
    @if ($this->hasSelected())
      <a type="button" class="btn btn-warning" wire:click="exportSelected">
        <i class="fas fa-file-export"></i> {{ __('messages.common.export_selected') }}
      </a>

      @hasrole('super_admin')
        <form action="{{ route('redirect-links.restore-selected') }}" method="POST" style="display: inline;"
          onsubmit="return confirm('{{ __('messages.redirect_links.restore_confirmation') }}')">
          @csrf
          <input type="hidden" name="ids" value="{{ implode(',', $this->getSelected()) }}">
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
