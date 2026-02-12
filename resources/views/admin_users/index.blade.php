@extends('layouts.app')
@section('title')
  {{ __('messages.admins') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column table-striped">
      @include('flash::message')

      <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" id="adminTabs" role="tablist">
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link active p-0" href="{{ route('admins.index') }}">
            {{ __('messages.admins') }}
          </a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
          <a class="nav-link p-0" href="{{ route('receipts.all') }}">
            {{ __('messages.receipts.receipts') }}
          </a>
        </li>
      </ul>

      <livewire:super-admin-table lazy />
    </div>
  </div>
  @include('users.changePassword')
@endsection

@section('scripts')
  <script>
    $(document).on('click', '.send-whatsapp-btn', function() {
      let userId = $(this).data('id');
      $.ajax({
        url: '{{ route('admins.get.credentials', ':id') }}'.replace(':id', userId),
        type: 'GET',
        dataType: 'json',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
          if (response.success && response.data) {
            let email = response.data.email || 'No email provided';
            let password = response.data.password;
            let phone = response.data.phone;
            let message = `Email: ${email}\nPassword: ${password}`;
            let whatsappUrl = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
          } else {
            alert('Error: ' + (response.message || 'Invalid response'));
          }
        },
        error: function() {
          alert('Error fetching credentials');
        }
      });
    });
  </script>
@endsection
