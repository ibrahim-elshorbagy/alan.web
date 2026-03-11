@if ($row->redirect_link)
  <div class="d-flex align-items-center gap-2">
    <a href="{{ $row->redirect_link }}" target="_blank">{{ $row->redirect_link }}</a>
    <a href="{{ route('client.redirect-links.edit', $row->id) }}" class="btn btn-sm btn-primary"
      title="{{ __('messages.common.edit') }}">
      <i class="fas fa-edit"></i>
    </a>
  </div>
@else
  @if ($row->redirect_link_type == 1)
    <div>
      <div class="d-flex align-items-center gap-2 mb-3">
        <a href="{{ route('client.redirect-links.edit', $row->id) }}" class="btn btn-sm btn-primary"
          title="{{ __('messages.common.edit') }}">
          <i class="fas fa-edit"></i>
        </a>
        <span class="text-muted">{{ __('messages.redirect_links.no_redirect_link_message') }}</span>
      </div>

      <div class="d-flex gap-2">
        <a href="{{ route('vcards.create') }}" class="btn btn-primary btn-sm">
          {{ __('messages.redirect_links.create_new_vcard') }}
        </a>
      </div>
    </div>
  @else

    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('client.redirect-links.edit', $row->id) }}" class="btn btn-sm btn-primary"
        title="{{ __('messages.common.edit') }}">
        <i class="fas fa-edit"></i>
      </a>
      <span class="text-muted">{{ __('messages.redirect_links.no_redirect_link_message') }}</span>
    </div>
  @endif
@endif
