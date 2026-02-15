<div>
  @php
    $hasActiveVcard = \App\Models\Vcard::where('tenant_id', $row->tenant_id)
        ->where('status', \App\Models\Vcard::ACTIVE)
        ->exists();
    $hasRedirectLink = \Illuminate\Support\Facades\DB::table('redirect_links')->where('user_id', $row->id)->exists();
  @endphp
  <div class="justify-content-center d-flex">
    <a title="{{ __('messages.user.change_password') }}" class="btn px-1 text-primary fs-3 user-change-password"
      data-id="{{ $row->id }}">
      <i class="fa-solid fa-key"></i>
    </a>
    <a href="{{ route('users.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"
      class="btn px-1 text-primary fs-3 user-edit-btn" data-id="{{ $row->id }}">
      <i class="fa-solid fa-pen-to-square"></i>
    </a>

    @if (!$hasActiveVcard && !$hasRedirectLink)
      <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
        class="btn px-1 text-danger fs-3 user-delete-btn">
        <i class="fa-solid fa-trash-can"></i>
      </a>
    @else
      <button type="button" class="btn px-1 text-secondary fs-3" disabled>
        <i class="fa-solid fa-trash-can"></i>
      </button>
    @endif
    @if (
        !empty($row->enable_two_factor_authentication) &&
            auth()->user() &&
            auth()->user()->hasAnyRole([ 'super_admin']))
      <a href="javascript:void(0)" data-id="{{ $row->id }}" data-url="{{ route('admin.disable.2fa', $row->id) }}"
        title="{{ __('messages.two_factor_auth.disable_2fa') }}" class="btn px-1 text-warning fs-3 admin-disable-2fa">
        <i class="fa-solid fa-shield-halved"></i>
      </a>
    @endif
  </div>
  </br>
  <script>
    if (!window.adminDisable2FABound) {
      document.addEventListener('click', function(e) {
        const target = e.target.closest('.admin-disable-2fa');
        if (!target) return;
        e.preventDefault();
        const url = target.getAttribute('data-url');
        if (!confirm(
            '{{ __('messages.two_factor_auth.confirm_disable_2fa_for_user') ?? 'Disable 2FA for this user?' }}'))
          return;

        $.ajax({
          url: url,
          type: 'POST',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(res) {
            displaySuccessMessage(res.message ||
              '{{ __('messages.two_factor_auth.two_factor_authentication_has_been_disabled') }}');
            setTimeout(function() {
              location.reload();
            }, 800);
          },
          error: function(err) {
            displayErrorMessage(err.responseJSON?.message ||
              '{{ __('messages.common.something_went_wrong') }}');
          }
        });
      });
      window.adminDisable2FABound = true;
    }
  </script>
</div>
