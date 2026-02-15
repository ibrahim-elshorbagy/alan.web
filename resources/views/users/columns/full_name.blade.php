<div>
  <div class="d-flex align-items-center">
    <a href="{{ route('users.show', $row->id) }}">
      <div class="image image-circle image-mini me-3">
        <img src="{{ $row->profile_image }}" alt="user" class="user-img">
      </div>
    </a>
    <div class="d-flex flex-column">
      <a href="{{ route('users.show', $row->id) }}" class="mb-1 text-decoration-none fs-6 text-info">
        {!! $row->full_name !!}
      </a>
      <span class="fs-6">{{ $row->email }}</span>
      <div class="mt-1">
        @if ($row->socialAccounts->where('provider', 'google')->count() > 0)
          <i class="fa-brands fa-google text-danger me-2" title="Registered with Gmail"></i>
        @elseif(!empty($row->contact))
          <i class="fa-solid fa-mobile-screen-button text-success me-2" title="Registered with Mobile"></i>
        @else
          <i class="fa-solid fa-envelope text-primary me-2" title="Registered with Email"></i>
        @endif
        @if ($row->enable_two_factor_authentication)
          <i class="fa-solid fa-shield-alt text-warning" title="2FA Enabled"></i>
        @endif
      </div>
    </div>
  </div>
</div>
