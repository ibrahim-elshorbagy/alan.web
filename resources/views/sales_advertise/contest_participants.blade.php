@extends('layouts.app')
@section('title')
  {{ __('messages.contest.participants') }} - {{ $contest->title }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-5">
          <h1><i class="fa-solid fa-trophy me-2" style="color: #ffd700;"></i>{{ __('messages.contest.participants') }}
          </h1>
          <a class="btn btn-outline-primary float-end" href="{{ url()->previous() }}">{{ __('messages.common.back') }}</a>
        </div>

        {{-- Contest info card --}}
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <strong>{{ __('messages.contest.contest_title') }}:</strong>
                <span>{{ $contest->title }}</span>
              </div>
              <div class="col-md-3">
                <strong>{{ __('messages.contest.draw_date') }}:</strong>
                <span>{{ $contest->draw_date->translatedFormat('Y-m-d h:i A') }}</span>
              </div>
              <div class="col-md-2">
                <strong>{{ __('messages.contest.num_winners') }}:</strong>
                <span class="badge bg-warning text-dark">{{ $contest->num_winners }}</span>
              </div>
              <div class="col-md-2">
                <strong>{{ __('messages.contest.total_participants') }}:</strong>
                <span class="badge bg-primary fs-6">{{ $totalCount }}</span>
              </div>
              <div class="col-md-2">
                <strong>{{ __('messages.contest.status') }}:</strong>
                <span class="badge {{ $contest->is_enabled ? 'bg-success' : 'bg-secondary' }}">
                  {{ $contest->is_enabled ? __('messages.contest.enabled') : __('messages.contest.disabled') }}
                </span>
              </div>
            </div>
            @if($contest->text)
              <div class="mt-3">
                <strong>{{ __('messages.contest.contest_text') }}:</strong>
                <p class="mb-0 text-muted">{{ $contest->text }}</p>
              </div>
            @endif
          </div>
        </div>

        {{-- Winners section --}}
        @if($winners->count() > 0)
          <div class="card mb-4 border-warning">
            <div class="card-header bg-warning text-dark">
              <strong><i class="fa-solid fa-crown me-2"></i>{{ __('messages.contest.winners') }}</strong>
            </div>
            <div class="card-body">
              <div class="row">
                @foreach($winners as $winner)
                  <div class="col-md-4 mb-3">
                    <div class="card border-warning h-100">
                      <div class="card-body text-center">
                        <div class="mb-2">
                          @if($winner->winner_rank == 1)
                            <i class="fa-solid fa-trophy fa-2x" style="color: gold;"></i>
                          @elseif($winner->winner_rank == 2)
                            <i class="fa-solid fa-medal fa-2x" style="color: silver;"></i>
                          @else
                            <i class="fa-solid fa-award fa-2x" style="color: #cd7f32;"></i>
                          @endif
                        </div>
                        <span
                          class="badge bg-warning text-dark mb-2">{{ __('messages.contest.winner_rank', ['rank' => $winner->winner_rank]) }}</span>
                        <h6 class="mb-1">{{ $winner->name }}</h6>
                        <p class="text-muted mb-0" dir="ltr">{{ $winner->phone }}</p>
                        <small class="text-muted">{{ $winner->won_at->translatedFormat('Y-m-d h:i A') }}</small>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        @endif

        {{-- Select Winners button --}}
        @if($totalCount > 0)
          <div class="card mb-4">
            <div class="card-body d-flex align-items-center gap-3">
              <form method="POST" action="{{ route('contests.select-winners', $contest->id) }}" id="selectWinnersForm">
                @csrf
                <button type="button" class="btn btn-warning btn-lg" onclick="confirmSelectWinners()">
                  <i class="fa-solid fa-dice me-2"></i>{{ __('messages.contest.select_winners') }}
                </button>
              </form>
              <span class="text-muted small">
                {{ __('messages.contest.select_winners_hint', ['count' => $contest->num_winners]) }}
              </span>
            </div>
          </div>
        @endif

        {{-- Filters --}}
        <div class="card mb-4">
          <div class="card-body">
            <form method="GET" action="{{ route('contest.participants', $contest->id) }}" class="row g-3 align-items-end">
              <div class="col-md-4">
                <label for="search" class="form-label">{{ __('messages.common.search') }}</label>
                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}"
                  placeholder="{{ __('messages.contest.search_placeholder') }}">
              </div>
              <div class="col-md-3">
                <label for="date_from" class="form-label">{{ __('messages.common.date_from') }}</label>
                <input type="date" name="date_from" id="date_from" class="form-control"
                  value="{{ request('date_from') }}">
              </div>
              <div class="col-md-3">
                <label for="date_to" class="form-label">{{ __('messages.common.date_to') }}</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
              </div>
              <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="fa-solid fa-search"></i>
                </button>
                <a href="{{ route('contest.participants', $contest->id) }}" class="btn btn-secondary">
                  <i class="fa-solid fa-rotate-left"></i>
                </a>
              </div>
            </form>
          </div>
        </div>

        {{-- Participants table --}}
        <div class="card">
          <div class="card-body">
            @if($participants->count() > 0)
              <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                  <thead class="table-light">
                    <tr>
                      <th style="width: 50px;">#</th>
                      <th>{{ __('messages.contest.participant_name') }}</th>
                      <th>{{ __('messages.contest.participant_phone') }}</th>
                      <th>{{ __('messages.contest.joined_at') }}</th>
                      <th>{{ __('messages.contest.winner_status') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($participants as $index => $participant)
                      <tr class="{{ $participant->winner_rank ? 'table-warning' : '' }}">
                        <td>{{ $participants->firstItem() + $index }}</td>
                        <td>
                          {{ $participant->name }}
                          @if($participant->winner_rank)
                            @if($participant->winner_rank == 1)
                              <i class="fa-solid fa-trophy ms-1" style="color: gold;"></i>
                            @elseif($participant->winner_rank == 2)
                              <i class="fa-solid fa-medal ms-1" style="color: silver;"></i>
                            @else
                              <i class="fa-solid fa-award ms-1" style="color: #cd7f32;"></i>
                            @endif
                          @endif
                        </td>
                        <td >{{ $participant->phone }}</td>
                        <td>{{ $participant->created_at->translatedFormat('Y-m-d h:i A') }}</td>
                        <td>
                          @if($participant->winner_rank)
                            <span class="badge bg-warning text-dark">
                              {{ __('messages.contest.winner_rank', ['rank' => $participant->winner_rank]) }}
                            </span>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              {{-- Pagination --}}
              <div class="d-flex justify-content-center mt-3">
                {{ $participants->links() }}
              </div>
            @else
              <div class="text-center text-muted py-4">
                <i class="fa-solid fa-users-slash fa-2x mb-2"></i>
                <p>{{ __('messages.contest.no_participants') }}</p>
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>

  <script>
    function confirmSelectWinners() {
      if (confirm(@json(__('messages.contest.confirm_select_winners')))) {
        document.getElementById('selectWinnersForm').submit();
      }
    }
  </script>
@endsection
