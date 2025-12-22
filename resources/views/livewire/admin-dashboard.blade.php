    {{-- Card --}}
    {{-- <div class="col-12 mb-4">
        <div class="row">
            <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                <div class="creat-vcard-card-bg shadow-md rounded-10 p-xxl-5 px-4 py-5 my-3 d-flex flex-column">
                    <div class="text-center text-white mb-1">
                        <h5 class="mb-2 fw-bold fs-14">{{ __('messages.hey') }} {{ Auth::user()->full_name }},</h5>
                        <p class="mb-3 opacity-90 card-detail">{{ __('messages.vcard_creat_card_detail') }}</</p>
                    </div>
                    <div class="text-center add-card">
                        <a href="{{ route('vcards.create') }}" class="btn btn-light fw-bold rounded-pill px-3 py-1 bg-white">+
                            {{ __('messages.add_new_card') }}</a>
                    </div>
                </div>
            </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-primary shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center
                     justify-content-between my-3 gap-3">
                     <div class="bg-cyan-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-id-card-clip fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $activeVcard }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.total__active_vcards') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-success shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="bg-green-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-user-large-slash fs-1-xl text-white"></i>
                         <img src="{{ asset('assets/img/dashboard/deactive-vcard.svg') }}" alt="" class="w-50 h-50">
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $deActiveVcard }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.total__deactive_vcards') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-info shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="bg-blue-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-question fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $enquiry }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.today_enquiry') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-warning shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="bg-yellow-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-calendar-check fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $appointment }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.today_appointments') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-danger shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="bg-red-300  widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-file-alt fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $totalWpTemplate }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.whatsapp_store') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="card-bg-purple shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="card-bg-purple-300  widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-cart-shopping fs-1-xl text-primary"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $totalOrder }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.whatsapp_store_order') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="card-bg-blue shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="card-bg-blue-300  widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-clock fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $totalPendingOrder }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.whatsapp_store_pending_order') }}</h3>
                     </div>
                 </div>
             </div>
         </div>
     </div> --}}

<div class="col-12 mb-4">
    <div class="row dashboard-card-row d-flex align-items-stretch">
        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-column align-items-center w-100">
                <div class="dashboard-card-content">
                    <h5 class="mb-2 fw-bold fs-14">{{ __('messages.hey') }} {{ Auth::user()->full_name }}</h5>
                    <p class="mb-2 fw-medium card-detail">{{ __('messages.vcard_creat_card_detail') }}</p>
                    <div class="add-card text-center">
                        <a href="{{ route('vcards.create') }}" class="btn btn-light fw-bold rounded-pill px-3 py-1 bg-white">+
                            {{ __('messages.add_new_card') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.total__active_vcards') }}</p>
                    <h5 class="fw-bold fs-30 mb-0">{{ $activeVcard }}</h5>
                </div>
                <!-- <div class="text-center">
                    <div class="card-icon d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-id-card-clip fs-1-xl text-white"></i>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.total__deactive_vcards') }}</p>
                    <h5 class="fw-bold fs-30 mb-0">{{ $deActiveVcard }}</h5>
                </div>
                <!-- <div class="text-center">
                    <div class="card-icon d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/dashboard/deactive-vcard.svg') }}" alt="" class="w-50 h-50">
                    </div>
                </div> -->
            </div>
        </div>

        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.today_enquiry') }}</p>
                    <h5 class="fw-bold fs-30 mb-0">{{ $enquiry }}</h5>
                </div>
                <!-- <div class="text-center">
                    <div class="card-icon d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-question fs-1-xl text-primary"></i>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.today_appointments') }}</p>
                    <h5 class="fw-bold fs-30 mb-0">{{ $appointment }}</h5>
                </div>
                <!-- <div class="text-center">
                    <div class="card-icon d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-calendar-check fs-1-xl text-white"></i>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.whatsapp_store') }}</p>
                    <h5 class="fw-bold fs-30 mb-0">{{ $totalWpTemplate }}</h5>
                </div>
                <!-- <div class="text-center">
                    <div class="card-icon d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-file-alt fs-1-xl text-white"></i>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.whatsapp_store_order') }}</p>
                    <h5 class="fw-bold fs-30 mb-0">{{ $totalOrder }}</h5>
                </div>
                <!-- <div class="text-center">
                    <div class="card-icon d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-cart-shopping fs-1-xl text-white"></i>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.whatsapp_store_pending_order') }}</p>
                    <h5 class="fw-bold fs-30 mb-0">{{ $totalPendingOrder }}</h5>
                </div>
                <!-- <div class="text-center">
                    <div class="card-icon d-flex justify-content-center align-items-center">
                        <i class="fa-solid fa-clock fs-1-xl text-white"></i>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
