@extends('layouts.app')
@section('title')
  {{ __('messages.contest.edit_contest') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12 col-lg-8">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1><i class="fa-solid fa-trophy me-2"></i>{{ __('messages.contest.edit_contest') }}</h1>
          <a class="btn btn-outline-secondary"
            href="{{ auth()->user()->hasRole('super_admin') ? route('redirect-links.edit', $contest->redirect_link_id) : route('client.redirect-links.edit', $contest->redirect_link_id) }}">{{ __('messages.common.back') }}</a>
        </div>

        @include('layouts.errors')

        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ route('contests.update', $contest->id) }}">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-lg-8 mb-4">
                  <label class="form-label fw-bold required">{{ __('messages.contest.contest_title') }}</label>
                  <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $contest->title) }}" required
                    placeholder="{{ __('messages.contest.contest_title_placeholder') }}">
                  @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-lg-4 mb-4">
                  <label class="form-label fw-bold required">{{ __('messages.contest.num_winners') }}</label>
                  <input type="number" name="num_winners" class="form-control @error('num_winners') is-invalid @enderror"
                    value="{{ old('num_winners', $contest->num_winners) }}" min="1" required>
                  @error('num_winners')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-lg-6 mb-4">
                  <label class="form-label fw-bold required">{{ __('messages.contest.draw_date') }}</label>
                  <input type="datetime-local" name="draw_date"
                    class="form-control @error('draw_date') is-invalid @enderror"
                    value="{{ old('draw_date', $contest->draw_date->format('Y-m-d\TH:i')) }}" required>
                  @error('draw_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 mb-4">
                  <label class="form-label fw-bold">{{ __('messages.contest.contest_text') }}</label>
                  <textarea name="text" class="form-control @error('text') is-invalid @enderror" rows="3"
                    placeholder="{{ __('messages.contest.contest_text_placeholder') }}">{{ old('text', $contest->text) }}</textarea>
                  @error('text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="fa-solid fa-save me-1"></i> {{ __('messages.common.save') }}
                </button>
                <a href="{{ auth()->user()->hasRole('super_admin') ? route('redirect-links.edit', $contest->redirect_link_id) : route('client.redirect-links.edit', $contest->redirect_link_id) }}"
                  class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection