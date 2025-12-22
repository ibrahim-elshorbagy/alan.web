<div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column flex-sm-row flex-wrap gap-3 align-items-sm-center justify-content-sm-between">
                <div>
                    @if (count($vcards) > 0 || !empty($search))
                        <div class="position-relative d-flex align-items-center min-width-220">
                            <span
                                class="position-absolute d-flex align-items-center top-0 bottom-0 left-0 text-gray-600 ms-3">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input wire:model.debounce.100ms.live="search" type="search" autocomplete="off"
                                class="form-control ps-8" id="search" placeholder="{{ __('auth.app.search') }}"
                                aria-label="Search">
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-end ms-auto">
                    <div class="btn-group d-flex align-items-end me-2" role="group"
                        aria-label="Basic mixed styles example" wire:ignore>
                        <button type="button"
                            class="btn border-white table-view-show {{ isset(getLogInUser()->vcard_table_view_type) && getLogInUser()->vcard_table_view_type == 0 ? 'btn-primary' : 'btn-white' }}"
                            data-value="0"><i class="fa fs-2 fa-table" aria-hidden="true"></i></button>
                        <button type="button"
                            class="btn border-white table-view-show {{ isset(getLogInUser()->vcard_table_view_type) && getLogInUser()->vcard_table_view_type == 1 ? 'btn-primary' : 'btn-white' }}"
                            data-value="1"><i class="fa-solid fs-2 fa-image"></i></button>
                    </div>
                    @if (checkTotalVcard())
                        <div class="">
                            <a type="button" class="btn btn-primary"
                                href="{{ route('vcards.create') }}">{{ __('messages.vcard.new_vcard') }}</a>
                        </div>
                    @endif
                </div>
            </div>
            @if (count($vcards) > 0)
                <div class="content">
                    <div class="position-relative">
                        @php
                            $styleCss = 'style';
                        @endphp
                        <div class="row g-4 mt-0">
                            @foreach ($vcards as $vcard)
                                <?php
                                $vcardUrl = $isCustomDomainUse ? "https://{$customDomain->domain}/{$vcard->url_alias}" : route('vcard.show', ['alias' => $vcard->url_alias]);
                                ?>
                                <div class="col-md-6 col-lg-6 col-12 col-xl-4">
                                    <div class="card h-100 d-block vcard-container position-relative ">
                                        <div class="card-body h-100 position-relative p-0 d-flex flex-column justify-content-between">
                                            <div class="vcard-edit-icon">
                                                <a href="{{ route('vcards.edit', $vcard->id) }}"
                                                    title="{{ __('messages.common.edit') }}"
                                                    class="btn px-1 py-0 fs-3">
                                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                                </a>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-sm dropdown-toggle hide-arrow"
                                                        type="button" id="dropdownMenuButton1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i
                                                            class="fa-solid fa-ellipsis-vertical text-center text-primary fs-4"></i>
                                                    </button>
                                                    <ul class="dropdown-menu px-2"
                                                        aria-labelledby="dropdownMenuButton1">
                                                        <li>
                                                            <div class="qr-code-image d-none">
                                                                {!! QrCode::size($vcard->qr_code_download_size)->format('svg')->generate($vcardUrl) !!}
                                                            </div>
                                                            <a title="{{ __('messages.vcard.qr_code') }}"
                                                                class="d-flex align-items-center btn p-1 fs-6 vcard-qr-code-btn d-flex"
                                                                download="qr_code.png">
                                                                <i
                                                                    class="fa-solid fa-qrcode text-info me-2 fs-4"></i>
                                                                <span>{{ __('messages.vcard.qr_code') }}</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a title="{{ __('messages.vcard.download_vcard') }}"
                                                                href="{{ route('add-contact', $vcard->id) }}"
                                                                class="btn p-1 fs-6 d-flex align-items-center"
                                                                data-turbo="false">
                                                                <i
                                                                    class="fas fa-download text-info fs-4 me-2"></i>&nbsp;{{ __('messages.vcard.download_vcard') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            @if (route('enquiry.index', $vcard->id))
                                                                <a title="{{ __('messages.enquiry') }}"
                                                                    href="{{ route('enquiry.index', $vcard->id) }}"
                                                                    class="btn p-1 fs-6 d-flex align-items-center">
                                                                    <i
                                                                        class="fa-solid fa-clipboard-question text-info fs-4 me-2"></i>&nbsp;{{ __('messages.contact_us.inquries') }}
                                                                </a>
                                                            @endif
                                                        </li>
                                                        @if (checkTotalVcard())
                                                            <li>
                                                                <a href="javascript:void(0)"
                                                                    class="duplicate-vcard-btn btn p-1 fs-6 d-flex align-items-center"
                                                                    data-id="{{ $vcard->id }}"
                                                                    title="{{ __('Duplicate vCard') }}">
                                                                    <i
                                                                        class="fa-solid fa-copy text-secondary fs-4 me-2"></i>&nbsp;{{ str_replace('!', '', __('messages.vcard.duplicate_vcard')) }}
                                                                </a>
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                data-id="{{ $vcard->id }}"
                                                                title="{{ __('messages.common.delete') }}"
                                                                class="btn p-1 fs-6 d-flex align-items-center text-danger  vcard_delete-btn">
                                                                <i
                                                                    class="fa-solid fa-trash fs-4 me-2"></i>&nbsp;{{ __('messages.common.delete') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <div class="status">
                                                                <div class="status">
                                                                    <button
                                                                        title="{{ __('messages.status') }}"
                                                                        class="btn p-1 fs-6 d-flex align-items-center vcardStatus"
                                                                        data-id="{{ $vcard->id }}"
                                                                        value="{{ $vcard->status == 1 ? '0' : '1' }}">
                                                                        @if ($vcard->status == 1)
                                                                            <i
                                                                                class="fa fa-toggle-on text-info fs-2 me-2"></i>
                                                                            {{ __('messages.vcard.disabled') }}
                                                                        @else
                                                                            <i
                                                                                class="fa fa-toggle-off text-info fs-2 me-2"></i>
                                                                            {{ __('messages.vcard.enable') }}
                                                                        @endif
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                                <div class="card-img">
                                                        <img src="{{ empty($vcard->template) ? $defaultTemplate : $vcard->template->template_url }}"
                                                            alt="Vcard" width="100" class="overflow-hidden h-20">
                                                        @if ($vcard->status == 0)
                                                            <span
                                                                class="badge badge-tag position-absolute py-1 px-5 d-flex justify-content-center align-items-center">{{ __('messages.vcard.disabled') }}</span>
                                                        @endif
                                                </div>
                                               <div class="d-flex flex-column justify-content-between h-100 gap-3 body-content flex-grow-1">
                                                <div class="desc p-4">
                                                    <div
                                                        class="justify-content-between align-items-center  d-flex">
                                                        <div>
                                                            <a href="{{ route('vcards.edit', $vcard->id) }}"
                                                                class="text-decoration-none fs-6">
                                                                {{ $vcard->name }}
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="fs-6 text-gray-500">{{ getFormattedDateTime($vcard->created_at) }}</span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="justify-content-between align-items-center  d-flex">
                                                        <div>
                                                            <span
                                                                class="fs-6 text-gray-500">{{ \Illuminate\Support\Str::words($vcard->occupation, 3, '...') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vcard-actions px-4 pb-4">
                                                    <div class="d-flex w-100 justify-content-center align-items-center">
                                                        <span class="d-none"
                                                            id="vcardUrlCopy{{ $vcard->id }}">{{ $vcardUrl }}</span>
                                                        @if ($vcard->status == 1)
                                                            <div class="vcard-button show-vcard me-sm-2 me-1">
                                                                <a href="{{ $vcardUrl }}"
                                                                    id="vcardUrl{{ $vcard->id }}"
                                                                    target="_blank"
                                                                    class="text-decoration-none fs-6">
                                                                    <span style="color:#0AC074">
                                                                        <i class="fa-solid fa-globe fs-2"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <div class="vcard-button vcard-link-copy mx-sm-2 mx-1">
                                                                <a class="user-edit-btn vcard-copy-clipboard fs-6"
                                                                    href="javascript:void(0)"
                                                                    data-id="{{ $vcard->id }}"
                                                                    title="{{ 'copy' }}">
                                                                    <span style="color:#FF8717;">
                                                                        <i class="fa-solid fa-copy fs-2"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <div
                                                                class="vcard-button vcard-Subscribers mx-sm-3 mx-1">
                                                                <a
                                                                    href="{{ route('vcard.showSubscribers', $vcard->id) }}">
                                                                    <span style="color:#4f76ad">
                                                                        <i class="fa-solid fa-users fs-2"></i></h3>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <div class="vcard-button vcard-Contact mx-sm-3 mx-1">
                                                                <a
                                                                    href="{{ route('vcard.showContact', $vcard->id) }}">
                                                                    <span style="color:#86469c">
                                                                        <i class="fa-solid fa-phone fs-2"></i></h3>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if (analyticsFeature())
                                                            <div class="vcard-button show-chart mx-sm-3 mx-1">
                                                                <a href="{{ route('vcard.analytics', $vcard->id) }}"
                                                                    class="fs-6">
                                                                    <i class="fa-solid fa-chart-line fs-2"></i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                               </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if ($vcards->count() > 0)
                        <div class="mt-0 mb-5 col-12">
                            <div class="row paginatorRow">
                                <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                                    <span class="d-inline-flex">
                                        {{ __('messages.showing') }}
                                        <span class="font-weight-bold mx-1">{{ $vcards->firstItem() }}</span> -
                                        <span class="font-weight-bold mx-1">{{ $vcards->lastItem() }}</span>
                                        <span>{{ __('messages.of') }}</span>
                                        <span class="font-weight-bold mx-1">{{ $vcards->total() }}</span>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                    {{ $vcards->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center empty-vcard">
                    @if (empty($search))
                        <h2 class="p-5">{{ __('messages.no_vcards_available') }}</h2>
                    @else
                        <h2 class="p-5">{{ __('messages.no_vcards_found') }}</h2>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
