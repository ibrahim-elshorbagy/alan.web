<div>
    <div class="d-flex align-items-center">
        <a href="{{ route('blogs.show', $row->id) }}">
            <div class="image image-circle image-mini me-3">
                <img src="{{ $row->blog_image }}" alt="user" class="user-img">
            </div>
        </a>
        <div class="d-flex flex-column">
            @if(Str::wordCount($row->title) > 5)
            <a href="{{ route('blogs.show', $row->id) }}" class="mb-1 text-decoration-none fs-6 text-primary">
                {{ Str::words($row->title, 5, ' ...') }}
            </a>
            @else
            <a href="{{ route('blogs.show', $row->id) }}" class="mb-1 text-decoration-none fs-6 text-primary">
                {{ $row->title }}
            </a>
            @endif
        </div>
    </div>
</div>
