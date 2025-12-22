<div class="d-flex align-items-center">
    <a>
        <div class="image image-circle image-mini me-3">
            @if(empty($row->template))
                <img src="{{ asset('assets/images/default_cover_image.jpg') }}" alt="vCard">
            @else
                <img src="{{$row->template->template_url}}" alt="vCard">
            @endif
        </div>
    </a>
    <div class="d-flex flex-column">
        <a class="text-decoration-none fs-6 text-info">
            {{$row->name}}
        </a>
        <span class="fs-6">{{$row->emaoccupationil}}</span>
    </div>
</div>
