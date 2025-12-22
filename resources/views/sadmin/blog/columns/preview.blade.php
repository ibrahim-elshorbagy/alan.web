@if ($row->status)
    <a href="{{ route('fornt-blog-show', ['slug' => $row->slug]) }}" target="_blank"
        class="text-decoration-none fs-6 text-primary">{{ route('fornt-blog-show', ['slug' => $row->slug]) }}</a>
@else
    <span>
        {{ route('fornt-blog-show', ['slug' => $row->slug]) }}
    </span>
@endif
