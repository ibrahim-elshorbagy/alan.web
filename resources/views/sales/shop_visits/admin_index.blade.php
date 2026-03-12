@extends('layouts.app')
@section('title')
  {{ __('messages.shop_visits.title') }} - {{ $salesUser->first_name }} {{ $salesUser->last_name }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>{{ __('messages.shop_visits.title') }} - {{ $salesUser->first_name }} {{ $salesUser->last_name }}</h1>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.sales-visits.dashboard', $salesUser->id) }}" class="btn btn-info">
            <i class="fas fa-chart-bar"></i> {{ __('messages.shop_visits.dashboard') }}
          </a>
          <a href="{{ route('admins.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
        </div>
      </div>

      @include('flash::message')

      <div class="card">
        <div class="card-body table-responsive">
          <table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('messages.shop_visits.visited_at') }}</th>
                <th>{{ __('messages.shop_visits.city') }}</th>
                <th>{{ __('messages.shop_visits.area') }}</th>
                <th>{{ __('messages.shop_visits.street') }}</th>
                <th>{{ __('messages.shop_visits.shop_name') }}</th>
                <th>{{ __('messages.shop_visits.phone') }}</th>
                <th>{{ __('messages.shop_visits.cards_sold') }}</th>
                <th>{{ __('messages.shop_visits.notes') }}</th>
                <th>{{ __('messages.common.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($visits as $visit)
                <tr>
                  <td>{{ $loop->iteration + ($visits->currentPage() - 1) * $visits->perPage() }}</td>
                  <td>{{ $visit->visited_at->format('Y-m-d H:i') }}</td>
                  <td>{{ $visit->city }}</td>
                  <td>{{ $visit->area }}</td>
                  <td>{{ $visit->street }}</td>
                  <td>{{ $visit->shop_name }}</td>
                  <td dir="ltr">{{ $visit->phone }}</td>
                  <td>{{ $visit->cards_sold }}</td>
                  <td>{{ \Illuminate\Support\Str::limit($visit->notes, 40) }}</td>
                  <td>
                    <a href="{{ route('admin.sales-visits.edit', $visit->id) }}" class="btn btn-sm btn-primary"
                      title="{{ __('messages.common.edit') }}">
                      <i class="fas fa-edit"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="10" class="text-center text-muted">{{ __('messages.shop_visits.no_visits') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <div class="d-flex justify-content-center mt-3">
            {{ $visits->links() }}
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection