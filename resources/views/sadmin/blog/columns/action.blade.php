
<div class="justify-content-center d-flex">
    <a href="{{ route('blogs.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"
       class="btn px-1 text-primary fs-3 user-edit-btn" data-id="{{$row->id}}">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
        class="btn px-1 text-danger fs-3 blog-delete-btn" data-turbolinks="false">
        <i class="fa-solid fa-trash-can"></i>
    </a>
</div>

