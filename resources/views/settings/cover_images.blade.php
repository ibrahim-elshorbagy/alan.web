@extends('settings.edit')
@section('section')
  <div class="card w-100">
    <div class="card-body d-flex flex-column flex-md-row">
      @include('settings.setting_menu')

      <div class="w-100 ps-md-4">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
          <div>
            <h3 class="mb-1">{{ __('messages.cover_image.manage_cover_images') }}</h3>
          </div>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoverImageModal">
            <i class="fa fa-plus me-2"></i>{{ __('messages.cover_image.add_cover_image') }}
          </button>
        </div>

        {{-- Cover Images Grid --}}
        <div class="row g-4">
          @forelse($coverImages as $image)
            <div class="col-sm-6 col-md-4 col-lg-5">
              <div class="card h-100 shadow-sm hover-shadow transition">
                {{-- Image Container with Aspect Ratio --}}
                <div class="position-relative bg-light" style="padding-top: 75%; overflow: hidden;">
                  <img src="{{ $image->image_url }}" alt="{{ $image->name }}"
                    class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: contain;"
                    onerror="this.onerror=null; this.src='/images/placeholder.png';">

                  {{-- Status Badge --}}
                  <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge {{ $image->status ? 'bg-success' : 'bg-secondary' }}">
                      {{ $image->status ? __('messages.common.active') : __('messages.common.inactive') }}
                    </span>
                  </div>
                </div>

                <div class="card-body">
                  <h6 class="card-title mb-3 text-truncate fw-semibold" title="{{ $image->name }}">
                    {{ $image->name }}
                  </h6>

                  <div class="d-flex justify-content-between align-items-center gap-2">
                    {{-- Action Buttons --}}
                    <div class="btn-group btn-group-sm" role="group">
                      <button type="button" class="btn btn-outline-primary mx-2 rounded"
                        onclick="editCoverImage({{ $image->id }}, '{{ addslashes($image->name) }}')"
                        title="{{ __('messages.common.edit') }}">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="button" class="btn btn-outline-danger mx-2 rounded"
                        onclick="deleteCoverImage({{ $image->id }})" title="{{ __('messages.common.delete') }}">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>

                    {{-- Status Toggle --}}
                    <div class="form-check form-switch mb-0">
                      <input class="form-check-input" type="checkbox" role="switch" id="status-{{ $image->id }}"
                        {{ $image->status ? 'checked' : '' }} onchange="updateStatus({{ $image->id }})"
                        title="{{ __('messages.common.toggle_status') ?? 'Toggle Status' }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="text-center py-5">
                <div class="text-muted">
                  <i class="fa fa-image fa-4x mb-3 opacity-50"></i>
                  <h5>{{ __('messages.cover_image.no_cover_images') }}</h5>
                  <p class="mb-3">
                    {{ __('messages.cover_image.no_cover_images_description') ?? 'Start by adding your first cover image' }}
                  </p>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addCoverImageModal">
                    <i class="fa fa-plus me-2"></i>{{ __('messages.cover_image.add_cover_image') }}
                  </button>
                </div>
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <style>
    .hover-shadow {
      transition: all 0.3s ease;
    }

    .hover-shadow:hover {
      transform: translateY(-4px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
  </style>

  {{-- Add Cover Image Modal --}}
  <div class="modal fade" id="addCoverImageModal" tabindex="-1" aria-labelledby="addCoverImageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCoverImageModalLabel">
            <i class="fa fa-plus-circle me-2"></i>{{ __('messages.cover_image.add_cover_image') }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('cover-images.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">
                {{ __('messages.cover_image.name') }} <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="name" name="name" required
                placeholder="{{ 'Enter cover image name' }}">
            </div>
            <div class="mb-3">
              <label for="image" class="form-label fw-semibold">
                {{ __('messages.cover_image.image') }} <span class="text-danger">*</span>
              </label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
              <div class="form-text">
                <i
                  class="fa fa-info-circle me-1"></i>{{ __('messages.cover_image.allowed_types') ?? 'Allowed: JPG, PNG, JPEG (Max: 5MB)' }}
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="fa fa-times me-1"></i>{{ __('messages.common.cancel') }}
            </button>
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save me-1"></i>{{ __('messages.common.save') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Edit Cover Image Modal --}}
  <div class="modal fade" id="editCoverImageModal" tabindex="-1" aria-labelledby="editCoverImageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCoverImageModalLabel">
            <i class="fa fa-edit me-2"></i>{{ __('messages.cover_image.edit_cover_image') }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editCoverImageForm" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_name" class="form-label fw-semibold">
                {{ __('messages.cover_image.name') }} <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="edit_name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="edit_image" class="form-label fw-semibold">
                {{ __('messages.cover_image.image') }}
              </label>
              <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
              <div class="form-text">
                <i
                  class="fa fa-info-circle me-1"></i>{{ __('messages.cover_image.leave_empty_to_keep') ?? 'Leave empty to keep current image' }}
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="fa fa-times me-1"></i>{{ __('messages.common.cancel') }}
            </button>
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save me-1"></i>{{ __('messages.common.save') }}
            </button>
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
      if (confirm(
          '{{ __('messages.cover_image.confirm_delete') ?? 'Are you sure you want to delete this cover image?' }}')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/sadmin/cover-images/${id}`;
        form.innerHTML = '@csrf @method('DELETE')';
        document.body.appendChild(form);
        form.submit();
      }
    }

    function updateStatus(id) {
      const checkbox = document.getElementById(`status-${id}`);
      fetch(`/sadmin/cover-images/${id}/status`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update badge
            const badge = checkbox.closest('.card').querySelector('.badge');
            if (badge) {
              badge.className = data.status ? 'badge bg-success' : 'badge bg-secondary';
              badge.textContent = data.status ? '{{ __('messages.common.active') }}' :
                '{{ __('messages.common.inactive') }}';
            }
          }
        })
        .catch(error => {
          console.error('Error:', error);
          checkbox.checked = !checkbox.checked; // Revert on error
        });
    }

    // Add fade-in animation for cards
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.hover-shadow');
      cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
          card.style.transition = 'all 0.4s ease';
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        }, index * 50);
      });
    });
  </script>
@endsection
