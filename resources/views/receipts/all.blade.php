@extends('layouts.app')
@section('title')
  {{ __('messages.receipts.all_receipts') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      @include('flash::message')

      <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" role="tablist">
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('admins.index') }}">
            {{ __('messages.admins') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link active p-0" href="{{ route('receipts.all') }}">
            {{ __('messages.receipts.receipts') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('acknowledgments.index') }}">
            {{ __('messages.acknowledgments') }}
          </a>
        </li>
      </ul>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">{{ __('messages.receipts.analytics') }}</h3>
                <a href="{{ route('receipts.all.pdf') }}" class="btn btn-primary" target="_blank">
                  <i class="fa fa-print"></i> {{ __('messages.common.print') }}
                </a>
              </div>

              <h5 class="mb-3 text-muted">{{ __('messages.common.sales_price') }}</h5>
              <div class="row">
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_required') }}:</label>
                    <p class="fs-4 text-info">{{ number_format($totalRequiredSalesPrice, 2) }}</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_paid') }}:</label>
                    <p class="fs-4 text-success">{{ number_format($totalPaid, 2) }}</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_after_paid') }}:</label>
                    <p class="fs-4 text-warning">{{ number_format($totalAfterPaidSalesPrice, 2) }}</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_remaining') }}:</label>
                    <p class="fs-4 {{ $totalRemainingSalesPrice >= 0 ? 'text-danger' : 'text-success' }}">
                      {{ number_format($totalRemainingSalesPrice, 2) }}
                      @if ($totalRemainingSalesPrice >= 0)
                        {{ __('messages.receipts.debtor') }}
                      @else
                        {{ __('messages.receipts.creditor') }}
                      @endif
                    </p>
                  </div>
                </div>
              </div>

              <hr>

              <div class="row mt-3">
                <div class="col-md-4">
                  <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('messages.receipts.total_receipts') }}:</label>
                    <p class="fs-4 text-primary">{{ $totalReceipts }}</p>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <livewire:all-receipts-table />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
