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
    @if($row->enable_two_factor_authentication && getLogInUser()->hasRole('super_admin'))
      <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.two_factor_auth.disable_2fa') }}"
        class="btn px-1 text-warning fs-3 admin-disable-2fa-btn">
        <i class="fa-solid fa-shield-halved"></i>
      </a>
    @endif
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
  </div>

</div>
