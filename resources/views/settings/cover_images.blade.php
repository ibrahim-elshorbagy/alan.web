@extends('settings.edit')
@section('section')
  <div class="card w-100">
    <div class="card-body d-md-flex">
      @include('settings.setting_menu')
      <div class="">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h4>{{ __('messages.cover_image.manage_cover_images') }}</h4>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoverImageModal">
              <i class="fa fa-plus"></i> {{ __('messages.cover_image.add_cover_image') }}
            </button>
          </div>
        </div>

        <div class="row">
          @forelse($coverImages as $image)
            <div class="col-md-3 mb-4">
              <div class="card">
                <div class="card-body text-center">
                  <img src="{{ $image->image_url }}" alt="{{ $image->name }}" class="img-fluid mb-3"
                    style="max-height: 150px;">
                  <h6>{{ $image->name }}</h6>
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-sm btn-outline-primary"
                      onclick="editCoverImage({{ $image->id }}, '{{ $image->name }}')">
                      <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteCoverImage({{ $image->id }})">
                      <i class="fa fa-trash"></i>
                    </button>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="status-{{ $image->id }}"
                        {{ $image->status ? 'checked' : '' }} onchange="updateStatus({{ $image->id }})">
                      <label class="form-check-label" for="status-{{ $image->id }}"></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center">
              <p>{{ __('messages.cover_image.no_cover_images') }}</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addCoverImageModalLabel">{{ __('messages.cover_image.add_cover_image') }}</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="{{ route('cover-images.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
        <div class="mb-3">
          <label for="name" class="form-label">{{ __('messages.cover_image.name') }}</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="image" class="form-label">{{ __('messages.cover_image.image') }}</label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
          <div class="form-text">{{ __('messages.cover_image.allowed_types') }}</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('messages.common.save') }}</button>
      </div>
    </form>
  </div>
</div>
</div>

<!-- Edit Cover Image Modal -->
<div class="modal fade" id="editCoverImageModal" tabindex="-1" aria-labelledby="editCoverImageModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCoverImageModalLabel">{{ __('messages.cover_image.edit_cover_image') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editCoverImageForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_name" class="form-label">{{ __('messages.cover_image.name') }}</label>
            <input type="text" class="form-control" id="edit_name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="edit_image" class="form-label">{{ __('messages.cover_image.image') }}</label>
            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
            <div class="form-text">{{ __('messages.cover_image.allowed_types') }}</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.common.save') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function editCoverImage(id, name) {
    document.getElementById('edit_name').value = name;
    document.getElementById('editCoverImageForm').action = `/sadmin/cover-images/${id}`;
    new bootstrap.Modal(document.getElementById('editCoverImageModal')).show();
  }

  function deleteCoverImage(id) {
    if (confirm('{{ __('messages.cover_image.confirm_delete') }}')) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/sadmin/cover-images/${id}`;
      form.innerHTML = '@csrf @method('DELETE')';
      document.body.appendChild(form);
      form.submit();
    }
  }

  function updateStatus(id) {
    fetch(`/sadmin/cover-images/${id}/status`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({}),
    });
  }
</script>
@endsection
