@extends('layouts.app')
@section('title')
  {{ __('messages.common.edit') }} {{ __('messages.acknowledgments') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">{{ __('messages.upload_signature') }}</h3>
      <a href="{{ route('acknowledgments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> {{ __('messages.common.back') }}
      </a>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <form action="{{ route('acknowledgments.update', $acknowledgment->id) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row mb-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label"><strong>{{ __('messages.received_by') }}:</strong></label>
                <p class="form-control-plaintext">
                  {{ $acknowledgment->salesUser->first_name }} {{ $acknowledgment->salesUser->last_name }}
                  <br><small class="text-muted">{{ $acknowledgment->salesUser->email }}</small>
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label"><strong>{{ __('messages.acknowledgment_date') }}:</strong></label>
                <p class="form-control-plaintext">{{ $acknowledgment->created_at->format('Y-m-d H:i') }}</p>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label"><strong>{{ __('messages.common.total') }}
                    {{ __('messages.common.items') }}:</strong></label>
                <p class="form-control-plaintext badge bg-primary fs-6">{{ $acknowledgment->total_count }}</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label"><strong>{{ __('messages.receipts.total_regular_selling_price') }}:</strong></label>
                <p class="form-control-plaintext text-success fw-bold">
                  ${{ number_format($acknowledgment->total_price, 2) }}</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label"><strong>{{ __('messages.receipts.total_selling_price_for_representative') }}:</strong></label>
                <p class="form-control-plaintext text-success fw-bold">
                  ${{ number_format($acknowledgment->total_sales_price, 2) }}</p>
              </div>
            </div>
          </div>

          <hr>

          @if ($acknowledgment->signature_file)
            <div class="mb-3">
              <label class="form-label"><strong>{{ __('messages.signature') }}
                  ({{ __('messages.common.current') }}):</strong></label>
              <div class="mb-2">
                <img src="{{ $acknowledgment->signature_url }}" alt="Signature" class="img-thumbnail"
                  style="max-height: 200px;">
              </div>
            </div>
          @endif

          <div class="mb-3">
            <label for="signature_file" class="form-label">
              <strong>{{ __('messages.upload_signature') }}:</strong>
              @if (!$acknowledgment->signature_file)
                <span class="text-danger">*</span>
              @endif
            </label>
            <input type="file" class="form-control @error('signature_file') is-invalid @enderror" id="signature_file"
              name="signature_file" accept="image/*,application/pdf">
            @error('signature_file')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
              {{ __('messages.common.allowed_formats') }}:
            </small>
          </div>

          <div class="mb-3">
            <label for="notes" class="form-label"><strong>{{ __('messages.common.notes') }}:</strong></label>
            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $acknowledgment->notes) }}</textarea>
            @error('notes')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex justify-content-between">
            <a href="{{ route('acknowledgments.view', $acknowledgment->id) }}" class="btn btn-info" target="_blank">
              <i class="fas fa-eye"></i> {{ __('messages.view_acknowledgment') }}
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> {{ __('messages.common.save') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
