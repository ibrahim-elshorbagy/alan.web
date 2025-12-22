@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-flex flex-column flex-md-row">
            @include('settings.setting_menu')
            <div class="w-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">{{ __('messages.custom_domain.steps_before_approving_custom_domain') }}</h3>
                    <a href="{{ route('setting.index', ['section' => 'custom_domain']) }}"
                        class="btn btn-secondary">{{ __('messages.common.back') }}</a>
                </div>
                <hr>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active custom-nav-link" id="cPanel-tab" data-bs-toggle="tab"
                            data-bs-target="#cPanel" type="button"
                            role="tab">{{ __('messages.custom_domain.cpanel') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link custom-nav-link" id="hostinger-tab" data-bs-toggle="tab"
                            data-bs-target="#hostinger" type="button"
                            role="tab">{{ __('messages.custom_domain.hostinger') }}</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="cPanel" role="tabpanel">
                        <div class="mt-5 ps-3">
                            <h4><strong>1. {{ __('messages.custom_domain.cpanel_msg1') }}</strong></h4>
                            <p>{{ __('messages.custom_domain.cpanel_msg2') }}</p>
                            <p>{{ __('messages.custom_domain.cpanel_msg3') }}
                                <code>custom-domain.com</code>:
                            </p>
                            <ul>
                                <li><a href="https://www.nslookup.io/" target="_blank">DNS Lookup</a></li>
                                <li><a href="https://www.whatsmydns.net/" target="_blank">What's My DNS</a></li>
                            </ul>

                            <p>{{ __('messages.custom_domain.cpanel_msg4') }}</p>

                            <h4><strong>2. {{ __('messages.custom_domain.cpanel_msg5') }}</strong></h4>
                            <h5><strong>2.1 {{ __('messages.custom_domain.cpanel_msg6') }}</strong></h5>
                            <p>{{ __('messages.custom_domain.cpanel_msg7') }}</p>
                            <img src="{{ asset('images/c1.png') }}" alt="AddOn Domain" class="img-fluid d-block mx-auto">
                            <h5 class="mt-3"><strong>2.2 {{ __('messages.custom_domain.cpanel_msg8') }}</strong></h5>
                            <p>{{ __('messages.custom_domain.cpanel_msg9') }}</p>
                            <img src="{{ asset('images/c2.png') }}" alt="Create New Domain" class="img-fluid">
                            <h5 class="mt-3"><strong>2.3 {{ __('messages.custom_domain.cpanel_msg10') }}</strong></h5>
                            <p>Example: Domain: <code>custom-domain.com</code>, Document Root:
                                <code>home/vcard/public_html</code>
                            </p>
                            <img src="{{ asset('images/c3.png') }}" alt="Add Domain Name and Document Root"
                                class="img-fluid d-block mx-auto">
                            <h5><strong>3. {{ __('messages.custom_domain.cpanel_msg11') }}</strong></h5>
                            <p>{{ __('messages.custom_domain.cpanel_msg12') }}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="hostinger" role="tabpanel">
                        <div class="mt-5 ps-3">
                            <h4><strong>{{ __('messages.custom_domain.hostinger_msg1') }}</strong></h4>

                            <h4 class="mt-5"><strong>2. {{ __('messages.custom_domain.hostinger_msg2') }}</strong></h4>
                            <h5><strong>2.1 {{ __('messages.custom_domain.hostinger_msg3') }}</strong></h5>
                            <p>{{ __('messages.custom_domain.hostinger_msg4') }}</p>
                            <img src="{{ asset('images/hostinger4.png') }}" alt="Manage Hosting Plan" class="img-fluid d-block mx-auto">
                            <h5 class="mt-5"><strong>2.3 {{ __('messages.custom_domain.hostinger_msg5') }}</strong></h5>
                            <p>{{ __('messages.custom_domain.hostinger_msg6') }} (e.g.,
                                <code>custom-domain.com</code>).
                            </p>
                            <img src="{{ asset('images/h2.png') }}" alt="Add Parked Domain" class="img-fluid">
                            <h5 class="mt-3"><strong>3. {{ __('messages.custom_domain.hostinger_msg7') }}</strong></h5>
                            <p>{{ __('messages.custom_domain.hostinger_msg8') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
