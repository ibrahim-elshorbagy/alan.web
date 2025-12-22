<div class="modal fade common-modal-card" id="changeLanguageModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content"@if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') dir="rtl" @endif>
            <div class="modal-header">
                <h3>{{ __('messages.user.change_language') }}</h3>
                <button type="button" class="modal-close bg-transparent p-0 border-0 @if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') m-0 @endif" data-bs-dismiss="modal" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Menu / Close_MD"> <path id="Vector" d="M18 18L12 12M12 12L6 6M12 12L18 6M12 12L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                </button>
            </div>
            {{ Form::open(['id'=>'changeLanguageForm']) }}
                @csrf
                @method('PUT')
                <div class="modal-body pt-0"">
                    <div class="alert alert-danger d-none" id="editLanguageValidationErrorsBox"></div>
                    <div>
                            @php
                                $user = Auth::user();
                            @endphp
                            {{ Form::label('Language', __('messages.language').':',['class' => 'form-label']) }}
                            {{ Form::select('language', getAllLanguage(), isset($user) ? getCurrentLanguageName() : null, ['class' => 'form-control form-select', 'required', 'data-control' => 'select2','id' => 'selectLanguage','data-dropdown-parent' => '#changeLanguageModal']) }}
                    </div>
                </div>
                <div class="modal-footer pt-0 justify-content-start @if(getLogInUser()->language == 'ar' || getLogInUser()->language == 'fa') gap-2 @endif">
                {{ Form::button(__('messages.common.save'),['class' => 'btn btn-primary m-0','id' => 'languageChangeBtn']) }}
                {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary my-0 ms-5 me-0','data-bs-dismiss' => 'modal']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
