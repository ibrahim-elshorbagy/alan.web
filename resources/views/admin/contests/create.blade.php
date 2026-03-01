@extends('layouts.app')
@section('title')
  {{ __('messages.contest.add_contest') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12 col-lg-8">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1><i class="fa-solid fa-trophy me-2"></i>{{ __('messages.contest.add_contest') }}</h1>
          <a class="btn btn-outline-secondary"
            href="{{ auth()->user()->hasRole('super_admin') ? route('redirect-links.edit', $redirectLink->id) : route('client.redirect-links.edit', $redirectLink->id) }}">{{ __('messages.common.back') }}</a>
        </div>

        @include('layouts.errors')

        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ route('contests.store', $redirectLink->id) }}">
              @csrf
              <div class="row">
                <div class="col-lg-8 mb-4">
                  <label class="form-label fw-bold required">{{ __('messages.contest.contest_title') }}</label>
                  <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" required
                    placeholder="{{ __('messages.contest.contest_title_placeholder') }}">
                  @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-lg-4 mb-4">
                  <label class="form-label fw-bold required">{{ __('messages.contest.num_winners') }}</label>
                  <input type="number" name="num_winners" class="form-control @error('num_winners') is-invalid @enderror"
                    value="{{ old('num_winners', 1) }}" min="1" required>
                  @error('num_winners')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-lg-6 mb-4">
                  <label class="form-label fw-bold required">{{ __('messages.contest.draw_date') }}</label>
                  <input type="datetime-local" name="draw_date"
                    class="form-control @error('draw_date') is-invalid @enderror" value="{{ old('draw_date') }}" required>
                  @error('draw_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 mb-4">
                  <label class="form-label fw-bold">{{ __('messages.contest.contest_text') }}</label>
                  <textarea name="text" class="form-control @error('text') is-invalid @enderror" rows="3"
                    placeholder="{{ __('messages.contest.contest_text_placeholder') }}">{{ old('text') }}</textarea>
                  @error('text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="fa-solid fa-save me-1"></i> {{ __('messages.common.save') }}
                </button>
                <a href="{{ auth()->user()->hasRole('super_admin') ? route('redirect-links.edit', $redirectLink->id) : route('client.redirect-links.edit', $redirectLink->id) }}"
                  class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection