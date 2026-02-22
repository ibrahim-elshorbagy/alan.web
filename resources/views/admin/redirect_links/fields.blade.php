@php
  $isDisabled = auth()->user()->hasRole('sales') && isset($redirectLink) && $redirectLink->status == 2;
@endphp
<div class="row">
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('user_id', __('messages.redirect_links.user') . ':', ['class' => 'form-label']) }}
      <div class="d-flex gap-2 align-items-start">
        <div class="flex-grow-1">
          {{ Form::select('user_id', $users->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), isset($redirectLink) ? $redirectLink->user_id : null, ['class' => 'form-control', 'id' => 'user_id_select', 'placeholder' => __('messages.redirect_links.select_user'), 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
          @if(auth()->user()->hasRole('sales'))
            {{-- Hidden field to submit user_id value when the select is disabled --}}
            <input type="hidden" name="user_id" id="user_id_hidden"
              value="{{ isset($redirectLink) ? $redirectLink->user_id : '' }}">
          @endif
        </div>
        @if(!$isDisabled && (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('sales')) && !isset($redirectLink->user_id))
          <button type="button" class="btn btn-sm btn-success mt-1" data-bs-toggle="modal"
            data-bs-target="#createQuickUserModal" title="{{ __('messages.redirect_links.quick_user.create_new_user') }}">
            <i class="fas fa-plus"></i>
          </button>
        @endif
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('uri', __('messages.redirect_links.redeem_code') . ':', ['class' => 'form-label required']) }}
      {{ Form::text('uri', isset($redirectLink) ? $redirectLink->uri : null, ['class' => 'form-control', 'placeholder' => __('messages.redirect_links.redeem_code'), 'required', 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('redirect_link_type', __('messages.redirect_links.redirect_link_type') . ':', ['class' => 'form-label required']) }}
      {{ Form::select('redirect_link_type', collect(\App\Enums\RedirectLinkTypeEnum::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray(), isset($redirectLink) ? $redirectLink->redirect_link_type : null, ['class' => 'form-control', 'required', 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('nfcs_id', __('messages.redirect_links.nfc') . ':', ['class' => 'form-label required']) }}
      {{ Form::select('nfcs_id', $nfcs->pluck('name', 'id'), isset($redirectLink) ? $redirectLink->nfcs_id : null, ['class' => 'form-control', 'required', 'disabled' => auth()->user()->hasRole('sales') || $isDisabled]) }}
    </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('redirect_link', __('messages.redirect_links.redirect_link') . ':', ['class' => 'form-label']) }}
      {{ Form::text('redirect_link', isset($redirectLink) ? $redirectLink->redirect_link : null, ['class' => 'form-control', 'placeholder' => __('messages.redirect_links.redirect_link'), 'disabled' => $isDisabled]) }}
    </div>
  </div>

  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('status', __('messages.redirect_links.status') . ':', ['class' => 'form-label required']) }}
      @if (auth()->user()->hasRole('sales'))
        @if (isset($redirectLink) && $redirectLink->status == 2)
          {{ Form::select('status', [2 => __('messages.redirect_links.rejected')], 2, ['class' => 'form-control', 'required', 'disabled' => true]) }}
        @else
          {{ Form::select('status', [0 => __('messages.redirect_links.not_redeemed'), 1 => __('messages.redirect_links.redeemed')], isset($redirectLink) ? $redirectLink->status : 0, ['class' => 'form-control', 'required', 'disabled' => $isDisabled]) }}
        @endif
      @else
        {{ Form::select('status', [0 => __('messages.redirect_links.not_redeemed'), 1 => __('messages.redirect_links.redeemed'), 2 => __('messages.redirect_links.rejected')], isset($redirectLink) ? $redirectLink->status : 0, ['class' => 'form-control', 'required', 'disabled' => $isDisabled]) }}
      @endif
    </div>
  </div>
  @if (auth()->user()->hasRole('super_admin'))
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('price', __('messages.admin_price') . ':', ['class' => 'form-label']) }}
        {{ Form::number('price', isset($redirectLink) ? $redirectLink->price : null, ['class' => 'form-control', 'placeholder' => __('messages.admin_price'), 'step' => '0.01', 'min' => '0', 'disabled' => $isDisabled]) }}
      </div>
    </div>
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('sales_price', __('messages.common.sales_price') . ':', ['class' => 'form-label']) }}
        {{ Form::number('sales_price', isset($redirectLink) ? $redirectLink->sales_price : null, ['class' => 'form-control', 'placeholder' => __('messages.selling_price'), 'step' => '0.01', 'min' => '0', 'disabled' => $isDisabled]) }}
      </div>
    </div>
  @endif
  @if (auth()->user()->hasRole('sales'))
    {{-- Sales can reassign to other sales or super admin --}}
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('assigned_id', __('messages.redirect_links.assigned_to') . ':', ['class' => 'form-label']) }}
        {{ Form::select('assigned_id', $salesUsers->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), isset($redirectLink) ? $redirectLink->assigned_id : null, ['class' => 'form-control', 'placeholder' => __('messages.redirect_links.select_assignee'), 'disabled' => $isDisabled]) }}
        <small class="text-muted">{{ __('messages.redirect_links.reassign_resets_received_status') }}</small>
      </div>
    </div>
  @elseif (!auth()->user()->hasRole('sales'))
    <div class="col-lg-6">
      <div class="mb-5">
        {{ Form::label('assigned_id', __('messages.redirect_links.assigned_to') . ':', ['class' => 'form-label']) }}
        {{ Form::select('assigned_id', $salesUsers->mapWithKeys(fn($user) => [$user->id => $user->first_name . ' ' . $user->last_name])->toArray(), isset($redirectLink) ? $redirectLink->assigned_id : null, ['class' => 'form-control', 'disabled' => $isDisabled]) }}
      </div>
    </div>
  @endif
  <div class="col-lg-6">
    <div class="mb-5">
      {{ Form::label('received_status', __('messages.redirect_links.received_status') . ':', ['class' => 'form-label']) }}
      @if (auth()->user()->hasRole('sales'))
        {{ Form::select('received_status', [0 => __('messages.redirect_links.not_received'), 1 => __('messages.redirect_links.received')], isset($redirectLink) ? $redirectLink->received_status : 0, ['class' => 'form-control', 'disabled' => true]) }}
      @else
        {{ Form::select('received_status', [0 => __('messages.redirect_links.not_received'), 1 => __('messages.redirect_links.received')], isset($redirectLink) ? $redirectLink->received_status : 0, ['class' => 'form-control']) }}
      @endif
    </div>
    @if(isset($latestAcknowledgment))
      <div class="mb-3">
        <small class="text-info">
          <i class="fas fa-info-circle"></i>
          {{ __('messages.redirect_links.acknowledgment_info') }}: #{{ $latestAcknowledgment->id }}
        </small>
      </div>
    @endif
  </div>

  @if (auth()->user()->hasRole('super_admin') && isset($redirectLink) && $redirectLink->histories->isNotEmpty())
    {{-- History Section - Only for Super Admin --}}
    <div class="col-12">
      <div class="mb-5">
        <h4>{{ __('messages.redirect_links.history.title') }}</h4>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>{{ __('messages.redirect_links.history.action') }}</th>
                <th>{{ __('messages.common.description') }}</th>
                <th>{{ __('messages.redirect_links.history.old_value') }}</th>
                <th>{{ __('messages.redirect_links.history.new_value') }}</th>
                <th>{{ __('messages.redirect_links.history.changed_by') }}</th>
                <th>{{ __('messages.redirect_links.history.changed_at') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($redirectLink->histories as $history)
                <tr>
                  <td>
                    <span class="badge bg-info">
                      {{ __('messages.redirect_links.history.actions.' . $history->action) }}
                    </span>
                  </td>
                  <td>{{ $history->description ?? '-' }}</td>
                  <td>{{ $history->old_value ?? '-' }}</td>
                  <td>{{ $history->new_value ?? '-' }}</td>
                  <td>{{ $history->getChangedByDisplayName() }}</td>
                  <td>{{ $history->created_at->translatedFormat('Y-m-d h:i a') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endif


  <div>
    @if (!$isDisabled)
      {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
    @endif
    <a href="{{ route('redirect-links.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
  </div>
</div>

{{-- Quick Create User Modal --}}
@if(!$isDisabled && (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('sales')))
  <div class="modal fade" id="createQuickUserModal" tabindex="-1" aria-labelledby="createQuickUserModalLabel"
    aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" @if(getLogInUser()->language == 'ar') dir="rtl" @endif>
        <div class="modal-header">
          <h5 class="modal-title" id="createQuickUserModalLabel">
            {{ __('messages.redirect_links.quick_user.create_new_user') }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="quickUserErrors" class="alert alert-danger d-none"></div>
          <div class="mb-3">
            <label for="quick_first_name" class="form-label required">{{ __('messages.user.first_name') }}</label>
            <input type="text" class="form-control" id="quick_first_name"
              placeholder="{{ __('messages.user.first_name') }}">
          </div>
          <div class="mb-3">
            <label for="quick_last_name" class="form-label required">{{ __('messages.user.last_name') }}</label>
            <input type="text" class="form-control" id="quick_last_name"
              placeholder="{{ __('messages.user.last_name') }}">
          </div>
          <div class="mb-3">
            <label for="quick_phone"
              class="form-label required">{{ __('messages.redirect_links.quick_user.phone') }}</label>
            <input type="tel" id="quick_phone" class="form-control" placeholder="962 XXX XXXX" pattern="^(962)[1-9]\d{8}$"
              title="يرجى إدخال رقم هاتف أردني صالح يبدأ بـ 962 غير متبوع ب 0"
              style="padding: 8px 13px; padding-left: 50px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; background: #fafbfc; transition: all 0.3s ease; background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJDMTMuMSAyIDE0IDIuOSAxNCA0VjE2QzE0IDE3LjEgMTMuMSAxOCA5IDE4VjE2QzQuOSAxNiA0IDE1LjEgNCAxNFY0QzQgMi45IDQuOSAyIDYgMkgxOFoiIGZpbGw9IiM2MzY2RjEiLz4KPHN2ZyB4PSI2IiB5PSI2IiB3aWR0aD0iMTIiIGhlaWdodD0iMTIiIHZpZXdCb3g9IjAgMCAxMiAxMiIgZmlsbD0ibm9uZSI+Cjx0ZXh0IHg9IjAiIHk9IjEwIiBmb250LXNpemU9IjEwIiBmaWxsPSIjNjM2NkYxIj5KTzwvdGV4dD4KPHN2Zz4KPHN2Zz4K'); background-repeat: no-repeat; background-position: 10px center;">
            <small class="text-muted">يرجى إدخال رقم أردني يبدأ بـ 962 (مثال: 962799123456)</small>
            <div id="quick_phone_error" class="invalid-feedback"></div>
          </div>
        </div>
        <div class="modal-footer pt-0">
          <button type="button" class="btn btn-primary" id="saveQuickUserBtn">
            <span id="saveQuickUserSpinner" class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
            {{ __('messages.common.save') }}
          </button>
          <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Track unsaved changes
      let formChanged = false;

      // Prevent Enter key in quick-create modal from submitting the parent form
      (function () {
        const quickUserModal = document.getElementById('createQuickUserModal');
        if (!quickUserModal) {
          return;
        }

        // Handler to prevent Enter from submitting when modal is open
        function preventEnterSubmit(e) {
          if (e.key === 'Enter') {
            if (e.target && e.target.tagName && e.target.tagName.toLowerCase() !== 'textarea') {
              e.preventDefault();
              e.stopPropagation();
            }
          }
        }

        // Attach listener when modal is shown, remove when hidden
        quickUserModal.addEventListener('shown.bs.modal', function () {
          quickUserModal.addEventListener('keydown', preventEnterSubmit);
        });
        quickUserModal.addEventListener('hidden.bs.modal', function () {
          quickUserModal.removeEventListener('keydown', preventEnterSubmit);
        });

        // Also attach to inputs inside modal as a fallback
        const inputs = quickUserModal.querySelectorAll('input, select, button');
        inputs.forEach(function (input) {
          input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && e.target.tagName.toLowerCase() !== 'textarea') {
              e.preventDefault();
            }
          });
        });
      })();
      const mainForm = document.getElementById('redirectLinkEditForm');
      if (mainForm) {
        mainForm.addEventListener('change', function () { formChanged = true; });
        mainForm.addEventListener('input', function () { formChanged = true; });
        mainForm.addEventListener('submit', function () { formChanged = false; });
      }

      window.addEventListener('beforeunload', function (e) {
        if (formChanged) {
          e.preventDefault();
          e.returnValue = '{{ __("messages.redirect_links.quick_user.unsaved_changes") }}';
          return e.returnValue;
        }
      });

      // Quick user creation AJAX
      const saveBtn = document.getElementById('saveQuickUserBtn');
      if (saveBtn) {
        saveBtn.addEventListener('click', function () {
          const firstName = document.getElementById('quick_first_name').value.trim();
          const lastName = document.getElementById('quick_last_name').value.trim();
          const phone = document.getElementById('quick_phone').value.trim();
          const errorsDiv = document.getElementById('quickUserErrors');
          const spinner = document.getElementById('saveQuickUserSpinner');

          errorsDiv.classList.add('d-none');
          errorsDiv.textContent = '';

          if (!firstName || !lastName || !phone) {
            errorsDiv.textContent = '{{ __("messages.redirect_links.quick_user.fill_all_fields") }}';
            errorsDiv.classList.remove('d-none');
            return;
          }

          // Validate phone format (Jordanian: starts with 962, 12 digits total)
          const phonePattern = /^(962)[1-9]\d{8}$/;
          if (!phonePattern.test(phone)) {
            errorsDiv.textContent = 'يرجى إدخال رقم هاتف أردني صالح يبدأ بـ 962 غير متبوع ب 0 (مثال: 962799123456)';
            errorsDiv.classList.remove('d-none');
            return;
          }

          saveBtn.disabled = true;
          spinner.classList.remove('d-none');

          // Open the window NOW (synchronous user gesture) so browsers don't block it.
          // We'll set the real URL after the fetch succeeds.
          const whatsappWindow = window.open('', '_blank');

          fetch('{{ route("redirect-links.create-quick-user") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
            },
            body: JSON.stringify({
              first_name: firstName,
              last_name: lastName,
              contact: phone,
            }),
          })
            .then(response => response.json())
            .then(data => {
              saveBtn.disabled = false;
              spinner.classList.add('d-none');

              if (data.success) {
                const select = document.getElementById('user_id_select');
                const hiddenInput = document.getElementById('user_id_hidden');

                // Add the new user as an option and select it
                const newOption = new Option(data.user.full_name, data.user.id, true, true);
                select.appendChild(newOption);
                select.value = data.user.id;

                // For sales: also update the hidden input so the value is submitted
                if (hiddenInput) {
                  hiddenInput.value = data.user.id;
                }

                formChanged = true;

                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('createQuickUserModal'));
                modal.hide();

                // Clear the form
                document.getElementById('quick_first_name').value = '';
                document.getElementById('quick_last_name').value = '';
                document.getElementById('quick_phone').value = '';

                // Navigate the already-opened window to WhatsApp
                const loginUrl = '{{ route("login") }}';
                const whatsappMessage = encodeURIComponent(
                  'عزيزي، ' + data.user.full_name + '\n\n' +
                  'يمكنك الدخول للوحة التحكم عبر الرابط\n\n' +
                  loginUrl + '\n\n' +
                  'اسم الدخول ' + data.user.contact + '\n\n' +
                  'الباسوورد ' + data.user.password + '\n\n'
                );
                const whatsappUrl = 'https://wa.me/' + data.user.contact + '?text=' + whatsappMessage;
                if (whatsappWindow) {
                  whatsappWindow.location.href = whatsappUrl;
                }

              } else {
                errorsDiv.textContent = data.message || '{{ __("messages.redirect_links.quick_user.creation_failed") }}';
                errorsDiv.classList.remove('d-none');
              }
            })
            .catch(error => {
              saveBtn.disabled = false;
              spinner.classList.add('d-none');
              if (whatsappWindow) { whatsappWindow.close(); }
              errorsDiv.textContent = '{{ __("messages.redirect_links.quick_user.creation_failed") }}';
              errorsDiv.classList.remove('d-none');
              console.error('Error:', error);
            });
        });
      }
    });
  </script>
@endif