@extends('layouts.app')
@section('title')
  {{ __('messages.admins') }}
@endsection
@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column table-striped">
      @include('flash::message')

      <livewire:sales-agency-sales-users-table lazy />
    </div>
  </div>
  @include('sales_agency.sales_users.change_password')
@endsection

@section('scripts')
  <script>
    $(document).on('click', '.agency-send-whatsapp-btn', function () {
      let userId = $(this).data('id');

      $.ajax({
        url: '{{ route('sales-agency.admins.get.credentials', ':id') }}'.replace(':id', userId),
        type: 'GET',
        dataType: 'json',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        success: function (response) {
          if (response.success && response.data && response.data.whatsapp_url) {
            window.open(response.data.whatsapp_url, '_blank');
          } else {
            alert('Error: ' + (response.message || 'Invalid response'));
          }
        },
        error: function (xhr) {
          alert(xhr.responseJSON?.message || 'Error fetching credentials');
        }
      });
    });

    $(document).on('click', '.agency-admin-delete-btn', function (event) {
      event.preventDefault();
      let recordId = $(this).data('id');

      if (confirm('{{ __('messages.common.are_you_sure') }}')) {
        $.ajax({
          url: '{{ route('sales-agency.sales-users.destroy', ':id') }}'.replace(':id', recordId),
          type: 'DELETE',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function (response) {
            Livewire.dispatch('refresh');
            if (response && response.message) {
              toastr.success(response.message);
            }
          },
          error: function (xhr) {
            toastr.error(xhr.responseJSON?.message || '{{ __('messages.common.something_went_wrong') }}');
          }
        });
      }
    });

    $(document).on('click', '.agency-user-change-password', function () {
      let userId = $(this).attr('data-id');
      $('#agencyChangePasswordUserId').val(userId);
      $('#agencyChangeUserPasswordModal').modal('show').appendTo('body');
    });

    $(document).on('click', '#AgencyUserPasswordChangeBtn', function () {
      let userId = $('#agencyChangePasswordUserId').val();
      $(this).attr('disabled', true);

      $.ajax({
        url: '{{ route('sales-agency.changePassword', ':id') }}'.replace(':id', userId),
        type: 'PUT',
        data: $('#agencyChangeUserPasswordForm').serialize(),
        success: function (result) {
          $('#agencyChangeUserPasswordModal').modal('hide');
          toastr.success(result.message);
          $('#AgencyUserPasswordChangeBtn').attr('disabled', false);
          $('#agencyChangeUserPasswordForm')[0].reset();
        },
        error: function (xhr) {
          $('#AgencyUserPasswordChangeBtn').attr('disabled', false);
          toastr.error(xhr.responseJSON?.message || '{{ __('messages.common.something_went_wrong') }}');
        }
      });
    });
  </script>
@endsection
