@if ($row->redirect_link)
  <a href="{{ $row->redirect_link }}" target="_blank">{{ $row->redirect_link }}</a>
@else
  @if ($row->redirect_link_type == 1)
    <span class="text-muted">{{ __('messages.redirect_links.no_redirect_link_message') }}</span>
    <br>
    <a href="{{ route('vcards.create') }}"
      class="btn btn-primary btn-sm">{{ __('messages.redirect_links.create_new_vcard') }}</a>
  @else
    <span class="text-muted">{{ __('messages.redirect_links.no_redirect_link_message') }}</span>
  @endif
@endif
