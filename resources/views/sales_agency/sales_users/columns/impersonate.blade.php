<div>
  <div class="d-flex text-center">
    @if ($row->email_verified_at)
      <a href="{{ route('impersonate', $row->id) }}" class="btn btn-sm btn-info">
        {{ __('messages.user.impersonate') }}
      </a>
    @else
      <a href="javascript:void(0)" style="pointer-events: none;
   cursor: default;" class="btn btn-sm btn-secondary">
        {{ __('messages.user.impersonate') }}
      </a>
    @endif
  </div>
</div>
