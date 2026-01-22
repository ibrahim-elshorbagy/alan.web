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
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">{{ __('messages.receipts.salesman_info') }}: {{ $user->first_name }}
                  {{ $user->last_name }}</h3>
                <a href="{{ route('receipts.pdf', $user->id) }}" class="btn btn-primary" target="_blank">
                  <i class="fa fa-print"></i> {{ __('messages.common.print') }}
                </a>
              </div>

              <div class="row">
                <div class="col-md-2">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_sold_cards') }}:</label>
                    <p class="fs-4 text-primary">{{ $totalSold }}</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_regular_selling_price') }}:</label>
                    <p class="fs-4 text-purple">{{ number_format($soldAmountPrice, 2) }}</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="mb-3">
                    <label
                      class="form-label fw-bold">{{ __('messages.receipts.total_selling_price_for_representative') }}:</label>
                    <p class="fs-4 text-success">{{ number_format($soldAmountSalesPrice, 2) }}</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_received') }}:</label>
                    <p class="fs-4 text-info">{{ number_format($totalReceived, 2) }}</p>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.balance') }}</label>
                    <p class="fs-4 {{ $balanceSalesPrice >= 0 ? 'text-danger' : 'text-success' }}">
                      {{ number_format($balanceSalesPrice, 2) }}
                      @if ($balanceSalesPrice >= 0)
                        {{ __('messages.receipts.debtor') }}
                      @else
                        {{ __('messages.receipts.creditor') }}
                      @endif
                    </p>
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
