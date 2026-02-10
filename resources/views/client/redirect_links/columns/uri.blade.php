<a href="{{ url('/auto-' . $row->uri) }}" target="_blank">{{ url('/auto-' . $row->uri) }}</a>
<br>
<div style="min-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
  {{ $row->nfc ? $row->nfc->name : 'N/A' }}
</div>
