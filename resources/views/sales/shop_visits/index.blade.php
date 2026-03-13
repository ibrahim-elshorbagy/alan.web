@extends('layouts.app')
@section('title')
  {{ __('messages.shop_visits.title') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>{{ __('messages.shop_visits.title') }}</h1>
        <a href="{{ route('sales.shop-visits.create') }}" class="btn btn-primary">
          <i class="fas fa-plus"></i> {{ __('messages.shop_visits.add_visit') }}
        </a>
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
                  <td>{{ \Illuminate\Support\Str::limit($visit->notes, 40) }}</td>
                  <td>
                    <div class="d-flex gap-1">
                      <a href="{{ route('sales.shop-visits.edit', $visit->id) }}" class="btn btn-sm btn-primary"
                        title="{{ __('messages.common.edit') }}">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="{{ route('sales.shop-visits.destroy', $visit->id) }}" method="POST"
                        onsubmit="return confirm('{{ __('messages.common.delete_confirm') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="{{ __('messages.common.delete') }}">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center text-muted">{{ __('messages.shop_visits.no_visits') }}</td>
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