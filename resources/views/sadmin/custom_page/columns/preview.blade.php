@if ($row->status)
    <a href="{{ route('fornt-custom-page-show', ['slug' => $row->slug]) }}" target="_blank"
        class="text-decoration-none fs-6 text-primary">{{ route('fornt-custom-page-show', ['slug' => $row->slug]) }}</a>
@else
    <span>
        {{ route('fornt-custom-page-show', ['slug' => $row->slug]) }}
    </span>
@endif
