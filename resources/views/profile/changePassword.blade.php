<div class="modal fade common-modal-card" id="changePasswordModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" @if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') dir="rtl" @endif>
            <div class="modal-header">
                <h3>{{ __('messages.user.change_password') }}</h3>
                <button type="button" class="modal-close bg-transparent p-0 border-0 @if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') m-0 @endif" data-bs-dismiss="modal"aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Menu / Close_MD"> <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                </button>
            </div>
            {{ Form::open(['id'=>'changePasswordForm']) }}
            @csrf
            @method('PUT')
            <div class="modal-body pt-0">
                <div class="alert alert-danger d-none" id="editPasswordValidationErrorsBox"></div>
                <div class="mb-3">
                    {{ Form::label('current_password',__('messages.user.current_password').':', ['class' => 'form-label required']) }}
                    <div class="mb-3 position-relative">
                        {{Form::password('current_password',['class' => 'form-control' ,'placeholder' => __('messages.user.current_password'), 'autocomplete'=> 'off','aria-label' => 'Password','data-toggle' => 'password'])}}
                        <span class="position-absolute d-flex align-items-center top-0 bottom-0
                            @if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa')
                                start-0 ms-4
                            @else
                                end-0 me-4
                            @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    {{ Form::label('new_password',__('messages.user.new_password').':', ['class' => 'form-label required']) }}
                    <div class="mb-3 position-relative">
                        {{Form::password('new_password',['class' => 'form-control','placeholder' => __('messages.user.new_password'), 'autocomplete'=> 'off','aria-label' => 'Password','data-toggle' => 'password'])}}
                        <span class="position-absolute d-flex align-items-center top-0 bottom-0
                            @if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa')
                                start-0 ms-4
                            @else
                            end-0 me-4
                            @endif input-icon input-password-hide cursor-pointer text-gray-600">
                            <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                </div>
                <div>
                    {{ Form::label('confirm_password',__('messages.user.confirm_password').':', ['class' => 'form-label required']) }}
                    <div class="mb-3 position-relative">
                        {{Form::password('confirm_password',['class' => 'form-control','placeholder' => __('messages.user.confirm_password'), 'autocomplete'=> 'off','aria-label' => 'Password','data-toggle' => 'password'])}}
                        <span class="position-absolute d-flex align-items-center top-0 bottom-0
                            @if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa')
                                start-0 ms-4
                            @else
                                end-0 me-4
                            @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0 justify-content-start @if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') gap-2 @endif">
                {{ Form::button(__('messages.common.save'),['class' => 'btn btn-primary m-0','id' => 'passwordChangeBtn']) }}
                {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary my-0 ms-5 me-0','data-bs-dismiss' => 'modal']) }}
            </div>
            {{ Form::close()}}
        </div>
    </div>
</div>
