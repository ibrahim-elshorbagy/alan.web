<div>
  <div class="d-flex align-items-center">
    <a href="{{ route('sales-agency.sales-users.edit', $row->id) }}">
      <div class="image image-circle image-mini me-3">
        <img src="{{ $row->profile_image }}" alt="user" class="user-img">
      </div>
    </a>
    <div class="d-flex flex-column">
      <a href="{{ route('sales-agency.sales-users.edit', $row->id) }}" class="mb-1 text-decoration-none fs-6 text-info">
        {!! $row->full_name !!}
      </a>
      <span class="fs-6">{{ $row->email }}</span>
    </div>
  </div>
</div>