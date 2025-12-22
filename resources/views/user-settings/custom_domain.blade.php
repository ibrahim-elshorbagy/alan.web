@extends('settings.edit')
@section('section')
    @include('user-settings.add_dns_modal')
    <div class="card w-100">
        <div class="card-body d-md-flex">
            <div class="">
                <div class="">
                    @include('user-settings.setting_menu')
                </div>
            </div>

            <div class="w-100">
                {{-- <div class="d-flex justify-content-end align-items-center mb-3">
                    <div class="text-center" style="font-size: 16px !important">
                        <a type="button" class="text-primary" data-bs-toggle="modal" data-bs-target="#dnsRecordModal"
                            id="dnsModal">
                            {{ __('messages.custom_domain.add_dns_record') }}
                        </a><span class="text-danger ">
                            ({{ __('messages.custom_domain.required_steps') }})</span>
                    </div>
                </div> --}}
                <button type="button"
                    class="btn px-0 aside-menu-container__aside-menubar d-block d-xl-none d-lg-none d-block edit-menu"
                    onclick="openNav()">
                    <i class="fa-solid fa-bars fs-1"></i>
                </button>
                <div class="card-body p-3">
                    <div class="mb-3">
                        <label class="form-label required">{{ __('messages.custom_domain.custom_domain') }}:</label>
                        <form action="{{ route('custom.domain.store') }}" method="POST">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-9">
                                    <input type="text" name="domain" class="form-control mb-1"
                                        placeholder="your-domain.com" required
                                        @if ($customDomain) readonly value="{{ $customDomain->domain }}" @endif>
                                    @if (!$customDomain)
                                        <span class="text-muted"><b>{{ __('messages.custom_domain.note') }}: </b>
                                            {{ __('messages.custom_domain.note_msg') }}</span>
                                    @endif
                                    @if ($customDomain && $customDomain->is_approved == 0)
                                        <span class="text-success">{{ __('messages.custom_domain.already_applied') }}</span>
                                    @endif
                                    @if ($customDomain && $customDomain->is_approved == 1 && $customDomain->is_active)
                                        <span class="text-success">{{ __('messages.custom_domain.eligible') }}</span><br>
                                    @endif
                                    @if ($customDomain && $customDomain->is_approved == 2)
                                        <span
                                            class="text-danger">{{ __('messages.custom_domain.domain_reject') }}</span><br>
                                    @endif
                                    @if ($customDomain && $customDomain->is_approved == 1 && !$customDomain->is_active)
                                        <span
                                            class="text-danger">{{ __('messages.custom_domain.in_active') }}</span><br>
                                    @endif
                                    @if ($customDomain && $customDomain->is_approved == 1 && $customDomain->is_active)
                                        <div class="mt-3">
                                            <input type="hidden" id="customDomainId" value="{{ $customDomain->id }}">
                                            <input type="checkbox" name="use_url" class="form-check-input"
                                                id="useCustomDomainUrl"
                                                @if ($customDomain->is_use_vcard) checked @endif>&nbsp;
                                            <label class="form-check-label" for="useCustomDomainUrl">
                                                {{ __('messages.custom_domain.use_domain') }}
                                            </label>
                                        </div>
                                        {{-- Show Note button only if approved --}}
                                        <div class="mt-3 text-center">
                                                <button type="button" class="btn btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#noteModal{{ $customDomain->id }}">
                                                    {{ __('messages.custom_domain.follow_guide') }}
                                                </button>
                                        </div>
                                    @endif
                                    <div style="margin-top: 45px !important">
                                        <div class="container mt-5">
                                            <h2 class="fw-bold text-primary mb-3 text-center">{{ __('messages.custom_domain.how_work') }}</h2>
                                            <div class="border rounded p-3 bg-light">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-flex align-items-start mb-4">
                                                        <i class="fas fa-circle  me-2 mt-1" style="font-size: 10px;"></i>
                                                        <span class="fw-semibold">{{ __('messages.custom_domain.how_work_msg1') }}</span>
                                                    </li>
                                                    <li class="d-flex align-items-start mb-1">
                                                        <i class="fas fa-circle  me-2 mt-1" style="font-size: 10px;"></i>
                                                        <p class="fw-semibold text-dark">{{ __('messages.custom_domain.how_work_msg2') }} <span
                                                                class="text-primary">https://appurl.com/{alias}</span></p>
                                                    </li>
                                                    <li class="d-flex align-items-start">
                                                        <i class="fas fa-circle  me-2 mt-1" style="font-size: 10px;"></i>
                                                        <p class="fw-semibold text-dark">{{ __('messages.custom_domain.how_work_msg3') }} <span
                                                                class="text-primary">https://custom-domain/{alias}</span>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @if (!$customDomain)
                                    <div class="col-md-3">
                                        <button type="submit"
                                            class="btn btn-primary w-100">{{ __('messages.custom_domain.applay_for_custom_domain') }}</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Include Note Modal --}}
    @if ($customDomain && $customDomain->is_approved == 1)
        @include('user-settings.note_modal', ['customDomain' => $customDomain])
    @endif
@endsection
