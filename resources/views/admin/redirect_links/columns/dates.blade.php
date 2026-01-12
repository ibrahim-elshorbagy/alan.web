<div class="small text-muted">
  <div><strong>{{ __('messages.common.created') }}:</strong> {{ $row->created_at->format('d/m/Y h:i') }} {{ $row->created_at->format('A') == 'AM' ? 'ص' : 'م' }}</div>
  <div><strong>{{ __('messages.common.updated') }}:</strong> {{ $row->updated_at->format('d/m/Y h:i') }} {{ $row->updated_at->format('A') == 'AM' ? 'ص' : 'م' }}</div>

</div>
