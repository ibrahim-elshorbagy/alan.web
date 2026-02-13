@if ($row->email != 'sadmin@vcard.com')
  <div class="justify-content-center d-flex">
    <a title="{{ __('messages.user.change_password') }}" class="btn px-1 text-primary fs-3 user-change-password"
      data-id="{{ $row->id }}">
      <i class="fa-solid fa-key"></i>
    </a>
    <a href="{{ route('admins.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"
      class="btn px-1 text-primary fs-3 user-edit-btn" data-id="{{ $row->id }}">
      <i class="fa-solid fa-pen-to-square"></i>
    </a>

    @if (!empty($row->contact))
      <a href="javascript:void(0)" data-id="{{ $row->id }}" title="إعادة تعيين كلمة المرور وارسالها برسالة واتس لرقم المندوب"
        class="btn px-1 text-success fs-3 send-whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
      </a>
    @endif
    <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
      class="btn px-1 text-danger fs-3 admin-delete-btn" data-name="superAdmin">
      <i class="fa-solid fa-trash-can"></i>
    </a>
  </div>
@endif
