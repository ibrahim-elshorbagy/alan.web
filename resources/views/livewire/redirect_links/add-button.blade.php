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

    {{-- Date From Filter --}}
    <div class="filter-item flex-fill">
      <label class="form-label small mb-1">{{ __('messages.common.date_from') }}</label>
      <input type="date" class="form-control" wire:model.live="dateFromFilter">
    </div>

    {{-- Date To Filter --}}
    <div class="filter-item flex-fill">
      <label class="form-label small mb-1">{{ __('messages.common.date_to') }}</label>
      <input type="date" class="form-control" wire:model.live="dateToFilter">
    </div>

    {{-- Group By Filter (only for super admin) --}}
    @hasrole('super_admin')
      <div class="filter-item">
        <label class="form-label small mb-1">{{ __('messages.redirect_links.group_by') }}</label>
        <select class="form-control form-select" wire:model.live="groupByFilter">
          <option value="">{{ __('messages.redirect_links.no_grouping') }}</option>
          <option value="redirect_type">{{ __('messages.redirect_links.redirect_type') }}</option>
          <option value="nfc_card">{{ __('messages.redirect_links.card_type') }}</option>
          <option value="sales_rep">{{ __('messages.redirect_links.assigned_to') }}</option>
        </select>
      </div>
    @endhasrole
  </div>

  {{-- Buttons Row --}}
  <div class="d-flex flex-wrap gap-2">
    @if ($this->hasSelected())
      <a type="button" class="btn btn-warning" wire:click="exportSelected">
        <i class="fas fa-file-export"></i> {{ __('messages.common.export_selected') }}
      </a>

      <a type="button" class="btn btn-success" wire:click="markSelectedAsReceived">
        <i class="fas fa-check"></i> {{ __('messages.redirect_links.mark_selected_as_received') }}
      </a>

      @hasrole('super_admin')
        <button type="button" class="btn btn-info" @click="$wire.call('syncAndRestore')"
          onclick="return confirm('{{ __('messages.redirect_links.restore_confirmation') }}')">
          <i class="fas fa-undo"></i> {{ __('messages.redirect_links.restore_selected') }}
        </button>
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
