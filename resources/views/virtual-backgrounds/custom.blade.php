@extends('layouts.app')
@section('title')
    {{ __('messages.virtual_backgrounds') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1>{{ __('messages.common.add_virtual_background') }}</h1>
            <a class="btn btn-outline-primary float-end"
                href="{{ route('virtual-backgrounds.index') }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 p-2 d-flex align-items-center flex-column">
                <div class="card" id="frontCanvasContainer"
                    style="width: 100%; max-width: 500px; height: 300px; box-shadow: 0px 0px 15px -8px black; border-radius: 4px;">
                    <canvas id="frontCanvas" width="500" height="300"></canvas>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 p-2 d-flex align-items-center flex-column">
                <div class="card" id="backCanvasContainer"
                    style="width: 100%; max-width: 500px; height: 300px; box-shadow: 0px 0px 15px -8px black; border-radius: 4px;">
                    <canvas id="backCanvas" width="500" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="card p-3">
                <form data-turbo="false" id="custom-e-card-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt4">
                                    <label class="form-label required">{{ __('messages.vcard.select_size') }}</label>
                                    <select id="vcard_size" name="vcard_size" class="form-select" required>
                                        <option value="1" selected>{{ __('messages.common.horizontal') }}</option>
                                        <option value="0">{{ __('messages.common.vertical') }}</option>
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <label class="form-label required">{{ __('messages.vcard.vcard_name') }}</label>
                                    <select id="custom-e-vcard-id" name="vcard_id" required>
                                        <option value="">{{ __('messages.vcard.select') }}</option>
                                        @foreach ($vcards as $id => $vcard)
                                            <option value="{{ $id }}" @selected(old('vcard_id'))>
                                                {{ $vcard }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="custom-virtual-card-image">
                                    <div class="mb-3 ms-2" io-image-input="true">
                                        <label for="exampleInputImage"
                                            class="form-label required">{{ __('messages.e_card.add_ecard') . ':' }}</label>
                                        <span data-bs-toggle="tooltip" data-placement="top"
                                            data-bs-original-title="{{ __('messages.e_card.ecard_info') }}">
                                            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                                        </span>
                                        <div class="d-block mt-2">
                                            <div class="image-picker">
                                                <div class="image previewImage" id="exampleInputImage"
                                                    style="background-image: url('{{ asset('assets/img/placeholder.png') }}')">
                                                </div>
                                                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                    data-bs-toggle="tooltip" data-placement="top"
                                                    data-bs-original-title="{{ __('messages.tooltip.change_ecard') }}">
                                                    <label>
                                                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                        <input type="file" id="custom-e-card-logo" name="ecard-logo"
                                                            class="image-upload file-validation d-none" accept="image/*" />
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 ms-2" io-image-input="true">
                                        <label for="forntImage"
                                            class="form-label required">{{ __('messages.common.front_image') . ':' }}</label>
                                        <span data-bs-toggle="tooltip" data-placement="top"
                                        data-bs-original-title="{{ __('messages.tooltip.about_us_image') }}">
                                        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                                        </span>
                                        <div class="d-block mt-2">
                                            <div class="image-picker">
                                                <div class="image previewImage" id="forntImage"
                                                    style="background-image: url('{{ asset('assets/img/placeholder.png') }}')">
                                                </div>
                                                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                    data-bs-toggle="tooltip" data-placement="top"
                                                    data-bs-original-title="{{ __('messages.common.choose_front_image') }}">
                                                    <label>
                                                        <i class="fa-solid fa-pen"></i>
                                                        <input type="file" id="e-card-front-image"
                                                            name="e-card-front-image"
                                                            class="image-upload file-validation d-none" accept="image/*" />
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 ms-4" io-image-input="true">
                                        <label for="backInputImage"
                                            class="form-label required">{{ __('messages.common.back_image') . ':' }}</label>
                                        <span data-bs-toggle="tooltip" data-placement="top"
                                        data-bs-original-title="{{ __('messages.tooltip.about_us_image') }}">
                                        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                                        </span>
                                        <div class="d-block mt-2">
                                            <div class="image-picker">
                                                <div class="image previewImage" id="backInputImage"
                                                    style="background-image: url('{{ asset('assets/img/placeholder.png') }}')">
                                                </div>
                                                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                    data-bs-toggle="tooltip" data-placement="top"
                                                    data-bs-original-title="{{ __('messages.common.back_image') }}">
                                                    <label>
                                                        <i class="fa-solid fa-pen"></i>
                                                        <input type="file" id="e-card-back-image"
                                                            name="e-card-back-image"
                                                            class="image-upload file-validation d-none"
                                                            accept="image/*" />
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-text text-danger" id="logoImageValidationErrors"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <label class="form-label required">{{ __('messages.form.first_name') }}</label>
                                <input type="text" class="form-control" name="first_name" id="custom-card-first-name"
                                    required value="{{ old('first_name') }}"
                                    placeholder="{{ __('messages.form.f_name') }}" maxlength="10">
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="form-label required">{{ __('messages.form.last_name') }}</label>
                                <input type="text" class="form-control" name="last_name" id="custom-card-last-name"
                                    required value="{{ old('last_name') }}"
                                    placeholder="{{ __('messages.form.l_name') }}" maxlength="10">
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="form-label required">{{ __('messages.user.email') }}</label>
                                <input type="email" class="form-control" name="email" id="custom-card-email"
                                    required placeholder="{{ __('messages.form.enter_email') }}"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="form-label required">{{ __('messages.form.occupation') }}</label>
                                <input type="text" class="form-control" name="occupation" id="custom-card-occupation"
                                    required value="{{ old('occupation') }}"
                                    placeholder="{{ __('messages.form.occupation') }}" maxlength="20">
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="form-label required">{{ __('messages.user.location') }}</label>
                                <input type="text" class="form-control" name="location" id="custom-card-location"
                                    required value="{{ old('location') }}"
                                    placeholder="{{ __('messages.form.location') }}">
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('phone', __('messages.user.phone') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::tel('phone', null, ['class' => 'form-control phone', 'required', 'placeholder' => __('messages.form.phone'), 'id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                                    {{ Form::hidden('region_code', null, ['id' => 'prefix_code']) }}
                                    <span id="valid-msg"
                                        class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.valid_number') }}</span>
                                    <span id="error-msg"
                                        class="text-danger d-none fw-400 fs-small mt-2">{{ __('messages.placeholder.invalid_number') }}</span>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label class="form-label required">{{ __('messages.social.website') }}</label>
                                <input type="text" class="form-control" name="website" id="custom-card-website"
                                    required value="{{ old('website') }}"
                                    placeholder="{{ __('messages.form.website') }}">
                            </div>
                        </div>

                        <div class="col-lg-12 d-flex mt-5">
                            <button type="submit" class="btn btn-primary me-3">
                                {{ __('messages.common.download') }}
                            </button>
                            <a href="{{ route('virtual-backgrounds.index') }}"
                                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/fabric/fabric.min.js') }}"></script>
    <script src="{{ asset('assets/js/fabric/jszip.min.js') }}"></script>
@endpush
