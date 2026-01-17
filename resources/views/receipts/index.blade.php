@extends('layouts.app')
@section('title')
  {{ __('messages.receipts.receipts') }} - {{ $user->first_name }} {{ $user->last_name }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      @include('flash::message')

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h3 class="mb-4">{{ __('messages.receipts.salesman_info') }}: {{ $user->first_name }}
                {{ $user->last_name }}</h3>

              <div class="row">
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_sold_cards') }}:</label>
                    <p class="fs-4 text-primary">{{ $totalSold }}</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.sold_amount') }}:</label>
                    <p class="fs-4 text-success">{{ number_format($soldAmount, 2) }}</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_received') }}:</label>
                    <p class="fs-4 text-info">{{ number_format($totalReceived, 2) }}</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.balance') }}:</label>
                    <p class="fs-4 {{ $balance >= 0 ? 'text-danger' : 'text-success' }}">
                      {{ number_format($balance, 2) }}</p>
                  </div>
                </div>
              </div>

              <div class="mt-3">
                <a href="{{ route('admins.index') }}" class="btn btn-secondary">
                  <i class="fa fa-arrow-left"></i> {{ __('messages.common.back') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <livewire:receipts-table :userId="$user->id" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('receipts.add_receipt_modal')
  @include('receipts.edit_receipt_modal')

  <input type="hidden" id="userId" value="{{ $user->id }}">
@endsection

@section('scripts')
  <script src="{{ asset('assets/js/sadmin/receipts/receipt.js') }}"></script>
@endsection
