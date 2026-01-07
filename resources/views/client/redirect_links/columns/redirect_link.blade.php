@if($row->redirect_link)
  <a href="{{ $row->redirect_link }}" target="_blank">{{ $row->redirect_link }}</a>
@else
  <span class="text-muted">{{ __('messages.redirect_links.no_redirect_link_message') }}</span>
@endif
