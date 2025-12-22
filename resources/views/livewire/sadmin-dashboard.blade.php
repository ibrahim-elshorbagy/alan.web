      {{-- Card
      <div class="col-12 mb-4">
         <div class="row">
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-primary shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center
                     justify-content-between my-3 gap-3">
                     <div
                         class="bg-cyan-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-user fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $activeUsersCount }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{__('messages.common.total_active_users')}}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div
                     class="bg-success shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div
                         class="bg-green-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-id-card-clip fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $activeVcard }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.total__active_vcards') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div
                     class="bg-info shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div
                         class="bg-blue-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-user-large-slash fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $deActiveUsersCount }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.total_deactive_users') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div
                     class="bg-warning shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div
                         class="bg-yellow-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <img src="{{ asset('assets/img/dashboard/deactive-vcard.svg') }}" alt="" class="w-50 h-50">
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $deActiveVcard }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.total__deactive_vcards') }}</h3>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 --}}


<div class="col-12 mb-4">
    <div class="row dashboard-card-row d-flex align-items-stretch">
        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card widget d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{__('messages.common.total_active_users')}}</p>
                    <h5 class="fw-bolder fs-30 mb-0">{{ $activeUsersCount }}</h5>
                </div>
                <div class="text-center">
                   <!-- <div class="card-icon d-flex justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="30" viewBox="0 0 26 30" fill="none">
                        <path d="M12.3253 14.4511C14.3106 14.4511 16.0297 13.7391 17.4344 12.3341C18.8391 10.9295 19.5511 9.21087 19.5511 7.22536C19.5511 5.24044 18.8391 3.5216 17.4342 2.11646C16.0292 0.712031 14.3103 0 12.3253 0C10.3397 0 8.62101 0.712031 7.21641 2.1167C5.8118 3.52136 5.09947 5.24027 5.09947 7.22536C5.09947 9.21087 5.81174 10.9298 7.21664 12.3344C8.62154 13.7389 10.3404 14.4511 12.3253 14.4511ZM24.9685 23.0685C24.9279 22.484 24.846 21.8462 24.7254 21.1729C24.6036 20.4945 24.4469 19.8532 24.2591 19.267C24.0653 18.6612 23.8016 18.0629 23.4757 17.4895C23.1374 16.8944 22.7401 16.3762 22.2942 15.9498C21.828 15.5038 21.2572 15.1451 20.597 14.8834C19.9393 14.6233 19.2102 14.4915 18.4305 14.4915C18.1242 14.4915 17.8281 14.6171 17.2561 14.9895C16.8495 15.2543 16.4417 15.5171 16.0327 15.7782C15.6397 16.0286 15.1073 16.2632 14.4497 16.4756C13.8082 16.6832 13.1568 16.7885 12.5139 16.7885C11.871 16.7885 11.2198 16.6832 10.5775 16.4756C9.92068 16.2634 9.3883 16.0288 8.99572 15.7784C8.54045 15.4875 8.12853 15.222 7.77123 14.9892C7.19994 14.6168 6.90352 14.4912 6.5973 14.4912C5.81725 14.4912 5.08852 14.6232 4.43092 14.8837C3.77127 15.1449 3.20022 15.5035 2.73352 15.9501C2.28791 16.3767 1.89036 16.8946 1.5525 17.4895C1.22684 18.0629 0.963169 18.6609 0.769048 19.2672C0.581548 19.8534 0.42481 20.4945 0.303052 21.1729C0.182408 21.8454 0.100494 22.4833 0.0599468 23.0692C0.0196122 23.6589 -0.000380165 24.2497 5.47347e-06 24.8407C5.47347e-06 26.4068 0.497818 27.6745 1.4795 28.6095C2.44905 29.5322 3.7319 30.0002 5.29195 30.0002H19.7372C21.2972 30.0002 22.5796 29.5324 23.5494 28.6095C24.5313 27.6752 25.0291 26.4072 25.0291 24.8405C25.0289 24.2361 25.0086 23.6398 24.9685 23.0685Z" fill="white"/>
                    </svg>
                   </div> -->
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card widget d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.total__active_vcards') }}</p>
                    <h5 class="fw-bolder fs-30 mb-0">{{ $activeVcard }}</h5>
                </div>
                <!-- <div class="text-center">
                   <div class="card-icon d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-id-card-clip fs-1-xl text-white"></i>
                   </div>
                </div> -->
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card widget d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.total_deactive_users') }}</p>
                    <h5 class="fw-bolder fs-30 mb-0">{{ $deActiveUsersCount }}</h5>
                </div>
                <!-- <div class="text-center">
                   <div class="card-icon d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-user-large-slash fs-1-xl text-white"></i>
                   </div>
                </div> -->
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 dashboard-card widget d-flex">
            <div class="dashboard-card-bg my-3 d-flex flex-row justify-content-between gap-3 align-items-center w-100">
                <div class="dashboard-card-content d-flex flex-column justify-content-center">
                    <p class="fs-14 fw-medium">{{ __('messages.common.total__deactive_vcards') }}</p>
                    <h5 class="fw-bolder fs-30 mb-0">{{ $deActiveVcard }}</h5>
                </div>
                <!-- <div class="text-center">
                   <div class="card-icon d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/dashboard/deactive-vcard.svg') }}" alt="" class="w-50 h-50">
                   </div>
                </div> -->
            </div>
        </div>
     </div>
</div>
