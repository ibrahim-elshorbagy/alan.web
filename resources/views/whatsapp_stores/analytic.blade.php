@extends('layouts.app')
@section('title')
    {{ __('messages.whatsapp_stores.whatsapp_store_analytics') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1>@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                @if(getLogInUser() && getLoggedInUserRoleId() != getSuperAdminRoleId())
                    <a href="{{ route('whatsapp.stores') }}"
                       class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
                @else
                    <a href="{{ route('sadmin.whatsapp-stores.index') }}"
                       class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('content')
    @include('layouts.errors')
    @if(!empty($data['noRecord']))
        <div class="w-100 d-flex justify-content-center align-items-center fs-1">
            <span>{{$data['noRecord']}}</span>
        </div>
    @else
        {{ Form::hidden('analytic_whatsapp_store_id', $whatsappStore->id, ['id' => 'analyticWhatsappStoreId']) }}
        {{ Form::hidden('visitors', __('messages.analytics.visitors'), ['id' => 'analyticVisitors']) }}
        <div class="container-fluid">
            <div class="d-flex flex-column">
                <div class="card">
                    <div class="card-header">
                        <h1>{{ __('messages.whatsapp_stores.whatsapp_store_analytics') }}</h1>
                        {{-- <div class="ms-auto">
                            <button type="button" class="btn btn-icon btn-outline-primary me-5" id="whatsappStoreChangeChart">
                                <i class="fas fa-chart-bar  fs-1 fw-boldest chart"></i>
                            </button>
                        </div>
                        <div id="whatsappStoreTimeRange"
                             class="time_range d-flex time_range_width w-30 h-40px border p-2 justify-content-center align-items-center rounded-2">
                            <i class="far fa-calendar-alt "
                               aria-hidden="true"></i>&nbsp;&nbsp<span></span> <b
                                    class="caret"></b>
                        </div> --}}
                        <div class="d-flex gap-4 align-items-center">
                           <div class="graph-icon d-flex justify-content-center align-items-center" id="whatsappStoreChangeChart">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M1.8566 1.24718C1.69182 1.25029 1.53491 1.31825 1.41993 1.43633C1.30495 1.5544 1.24118 1.71306 1.24245 1.87787V18.1268C1.24182 18.2924 1.30684 18.4515 1.42328 18.5693C1.53972 18.6871 1.69808 18.7539 1.86369 18.7552H18.1174C18.2834 18.7552 18.4426 18.6892 18.56 18.5718C18.6774 18.4544 18.7433 18.2952 18.7433 18.1292C18.7433 17.9632 18.6774 17.804 18.56 17.6866C18.4426 17.5692 18.2834 17.5032 18.1174 17.5032H2.49201V1.87787C2.49265 1.79426 2.47654 1.71138 2.44463 1.6341C2.41272 1.55683 2.36565 1.48673 2.30621 1.42794C2.24676 1.36916 2.17614 1.32288 2.09851 1.29183C2.02089 1.26078 1.94019 1.2456 1.8566 1.24718ZM18.1032 5.31001C17.9416 5.31543 17.7884 5.38315 17.6757 5.49898L11.2625 11.9121L8.57444 8.95948C8.46261 8.83786 8.30723 8.76539 8.14218 8.75787C7.97714 8.75035 7.81581 8.80838 7.69338 8.91932L3.94471 12.3538C3.87965 12.4081 3.82627 12.475 3.78782 12.5505C3.74937 12.6259 3.72664 12.7084 3.72101 12.793C3.71537 12.8775 3.72695 12.9623 3.75505 13.0422C3.78314 13.1221 3.82716 13.1955 3.88445 13.2579C3.94173 13.3203 4.01109 13.3704 4.08831 13.4052C4.16554 13.44 4.24902 13.4588 4.33372 13.4604C4.41841 13.462 4.50255 13.4464 4.58104 13.4146C4.65953 13.3827 4.73073 13.3352 4.79034 13.2751L8.0784 10.2657L10.7759 13.2373C10.8328 13.2999 10.9017 13.3504 10.9786 13.3857C11.0554 13.4209 11.1387 13.4402 11.2232 13.4424C11.3078 13.4447 11.3919 13.4297 11.4705 13.3985C11.5491 13.3673 11.6206 13.3205 11.6806 13.2609L18.5544 6.38241C18.6431 6.2943 18.7034 6.18162 18.7275 6.05891C18.7517 5.9362 18.7385 5.80908 18.6897 5.69394C18.6409 5.5788 18.5587 5.48091 18.4537 5.4129C18.3488 5.34489 18.2259 5.30988 18.1008 5.31238L18.1032 5.31001Z" fill="#1C274C"/>
                                </svg>
                           </div>
                            <div id="whatsappStoreTimeRange" class="time_range time_range_width btn dashboard-calendar-btn align-items-center d-flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M20.2247 3.98175H19.3322V2.8155C19.3322 2.46661 19.1936 2.13201 18.9469 1.8853C18.7001 1.6386 18.3655 1.5 18.0167 1.5C17.6678 1.5 17.3332 1.6386 17.0865 1.8853C16.8398 2.13201 16.7012 2.46661 16.7012 2.8155V3.98175H13.346V2.8155C13.346 2.64275 13.312 2.47168 13.2459 2.31208C13.1798 2.15248 13.0829 2.00746 12.9607 1.8853C12.8386 1.76315 12.6936 1.66625 12.5339 1.60014C12.3743 1.53403 12.2033 1.5 12.0305 1.5C11.8578 1.5 11.6867 1.53403 11.5271 1.60014C11.3675 1.66625 11.2225 1.76315 11.1003 1.8853C10.9782 2.00746 10.8813 2.15248 10.8152 2.31208C10.7491 2.47168 10.715 2.64275 10.715 2.8155V3.98175H7.3599V2.8155C7.3599 2.46661 7.22131 2.13201 6.9746 1.8853C6.7279 1.6386 6.3933 1.5 6.0444 1.5C5.69551 1.5 5.36091 1.6386 5.11421 1.8853C4.8675 2.13201 4.7289 2.46661 4.7289 2.8155V3.98175H3.7749C3.24416 3.98433 2.7361 4.19731 2.36217 4.57398C1.98825 4.95065 1.77898 5.46025 1.78028 5.991V20.4911C1.77898 21.0219 1.9883 21.5316 2.36231 21.9083C2.73631 22.285 3.24447 22.4979 3.77528 22.5004H20.2247C20.7554 22.4978 21.2635 22.2848 21.6374 21.9081C22.0113 21.5315 22.2206 21.0219 22.2193 20.4911V5.991C22.2206 5.46018 22.0113 4.95053 21.6373 4.57385C21.2632 4.19717 20.7555 3.98423 20.2247 3.98175ZM17.4512 2.8155C17.4512 2.66552 17.5107 2.52168 17.6168 2.41563C17.7228 2.30958 17.8667 2.25 18.0167 2.25C18.1666 2.25 18.3105 2.30958 18.4165 2.41563C18.5226 2.52168 18.5822 2.66552 18.5822 2.8155V3.98175H17.4512V2.8155ZM11.465 2.8155C11.465 2.66552 11.5246 2.52168 11.6307 2.41563C11.7367 2.30958 11.8805 2.25 12.0305 2.25C12.1805 2.25 12.3243 2.30958 12.4304 2.41563C12.5364 2.52168 12.596 2.66552 12.596 2.8155V3.98175H11.465V2.8155ZM5.4789 2.8155C5.4789 2.66552 5.53848 2.52168 5.64454 2.41563C5.75059 2.30958 5.89442 2.25 6.0444 2.25C6.19438 2.25 6.33822 2.30958 6.44427 2.41563C6.55032 2.52168 6.6099 2.66552 6.6099 2.8155V3.98175H5.47853L5.4789 2.8155ZM3.7749 4.73175H4.7289V5.457C4.73035 5.66631 4.78146 5.87228 4.87804 6.05798C4.97462 6.24368 5.11391 6.4038 5.28444 6.52517C5.45498 6.64653 5.65189 6.72568 5.85898 6.75609C6.06607 6.78651 6.27742 6.76733 6.47565 6.70012C6.52219 6.684 6.5651 6.65886 6.60192 6.62615C6.63874 6.59344 6.66876 6.5538 6.69026 6.50949C6.71177 6.46518 6.72433 6.41707 6.72724 6.3679C6.73015 6.31873 6.72334 6.26947 6.70722 6.22294C6.69109 6.1764 6.66595 6.1335 6.63324 6.09667C6.60053 6.05985 6.56089 6.02983 6.51658 6.00833C6.47227 5.98682 6.42416 5.97426 6.37499 5.97135C6.32582 5.96844 6.27657 5.97525 6.23003 5.99137C6.1448 6.0202 6.05395 6.0284 5.96494 6.0153C5.87593 6.00221 5.7913 5.96818 5.71799 5.91603C5.64468 5.86387 5.58478 5.79507 5.54322 5.71528C5.50166 5.63548 5.47962 5.54697 5.4789 5.457V4.73175H10.715V5.457C10.7154 5.80577 10.8542 6.14014 11.1008 6.38676C11.3474 6.63338 11.6818 6.7721 12.0305 6.7725C12.3534 6.78862 12.8263 6.62925 12.6935 6.22312C12.6774 6.17658 12.6522 6.13367 12.6195 6.09685C12.5868 6.06003 12.5471 6.03001 12.5028 6.00853C12.4584 5.98704 12.4103 5.9745 12.3611 5.97162C12.312 5.96874 12.2627 5.97558 12.2162 5.99175C12.1309 6.02059 12.04 6.02878 11.951 6.01566C11.8619 6.00255 11.7773 5.96849 11.704 5.91629C11.6306 5.86409 11.5708 5.79524 11.5292 5.7154C11.4877 5.63556 11.4657 5.547 11.465 5.457V4.73175H16.7012V5.457C16.7026 5.66626 16.7537 5.87219 16.8503 6.05785C16.9468 6.24351 17.0861 6.4036 17.2566 6.52496C17.4271 6.64632 17.6239 6.72548 17.831 6.75593C18.038 6.78638 18.2493 6.76725 18.4475 6.70012C18.5409 6.66711 18.6174 6.59852 18.6604 6.50931C18.7033 6.42011 18.7093 6.31753 18.6769 6.22395C18.6445 6.13038 18.5764 6.05341 18.4875 6.00984C18.3986 5.96627 18.2961 5.95963 18.2023 5.99137C18.1171 6.02029 18.0262 6.02855 17.9371 6.01549C17.8481 6.00243 17.7634 5.96841 17.6901 5.91624C17.6167 5.86407 17.5568 5.79523 17.5153 5.71539C17.4738 5.63556 17.4518 5.547 17.4512 5.457V4.73175H20.2247C20.5565 4.73413 20.874 4.86803 21.1073 5.10409C21.3406 5.34015 21.4708 5.6591 21.4693 5.991V7.87912C21.414 7.8448 21.3506 7.8259 21.2855 7.82437L2.53028 7.84387V5.99137C2.52858 5.65928 2.65873 5.34008 2.89215 5.10385C3.12557 4.86762 3.44319 4.73366 3.77528 4.73137L3.7749 4.73175ZM20.2247 21.7504H3.7749C3.44301 21.748 3.1256 21.6141 2.89228 21.378C2.65896 21.142 2.52878 20.823 2.53028 20.4911V8.59387L21.2863 8.57437C21.3511 8.5727 21.4142 8.5538 21.4693 8.51962V20.4911C21.4708 20.8231 21.3405 21.1421 21.1071 21.3782C20.8737 21.6142 20.5566 21.7481 20.2247 21.7504Z" fill="#1C274C"/>
                                    <path d="M7.5235 10.3145H5.104C5.00455 10.3145 4.90917 10.354 4.83884 10.4243C4.76851 10.4946 4.729 10.59 4.729 10.6895V12.875C4.729 12.9744 4.76851 13.0698 4.83884 13.1401C4.90917 13.2104 5.00455 13.25 5.104 13.25H7.5235C7.62296 13.25 7.71834 13.2104 7.78867 13.1401C7.859 13.0698 7.8985 12.9744 7.8985 12.875V10.6895C7.8985 10.59 7.859 10.4946 7.78867 10.4243C7.71834 10.354 7.62296 10.3145 7.5235 10.3145ZM7.1485 12.5H5.479V11.0645H7.1485V12.5ZM12.8448 10.3145H10.4249C10.3254 10.3145 10.23 10.354 10.1597 10.4243C10.0894 10.4946 10.0499 10.59 10.0499 10.6895V12.875C10.0499 12.9744 10.0894 13.0698 10.1597 13.1401C10.23 13.2104 10.3254 13.25 10.4249 13.25H12.8444C12.9438 13.25 13.0392 13.2104 13.1095 13.1401C13.1799 13.0698 13.2194 12.9744 13.2194 12.875V10.6895C13.2194 10.59 13.1799 10.4946 13.1095 10.4243C13.0392 10.354 12.9442 10.3145 12.8448 10.3145ZM12.4698 12.5H10.7999V11.0645H12.4694L12.4698 12.5ZM18.1656 10.3145H15.7461C15.6467 10.3145 15.5513 10.354 15.481 10.4243C15.4106 10.4946 15.3711 10.59 15.3711 10.6895V12.875C15.3711 12.9744 15.4106 13.0698 15.481 13.1401C15.5513 13.2104 15.6467 13.25 15.7461 13.25H18.166C18.2655 13.25 18.3608 13.2104 18.4312 13.1401C18.5015 13.0698 18.541 12.9744 18.541 12.875V10.6895C18.541 10.59 18.5015 10.4946 18.4312 10.4243C18.3608 10.354 18.2651 10.3145 18.1656 10.3145ZM17.7906 12.5H16.1211V11.0645H17.791L17.7906 12.5ZM7.5235 15.6353H5.104C5.00455 15.6353 4.90917 15.6748 4.83884 15.7452C4.76851 15.8155 4.729 15.9109 4.729 16.0103V18.1958C4.729 18.2953 4.76851 18.3907 4.83884 18.461C4.90917 18.5313 5.00455 18.5708 5.104 18.5708H7.5235C7.62296 18.5708 7.71834 18.5313 7.78867 18.461C7.859 18.3907 7.8985 18.2953 7.8985 18.1958V16.0103C7.8985 15.9109 7.859 15.8155 7.78867 15.7452C7.71834 15.6748 7.62296 15.6353 7.5235 15.6353ZM7.1485 17.8208H5.479V16.3853H7.1485V17.8208ZM12.8448 15.6353H10.4249C10.3254 15.6353 10.23 15.6748 10.1597 15.7452C10.0894 15.8155 10.0499 15.9109 10.0499 16.0103V18.1958C10.0499 18.2953 10.0894 18.3907 10.1597 18.461C10.23 18.5313 10.3254 18.5708 10.4249 18.5708H12.8444C12.9438 18.5708 13.0392 18.5313 13.1095 18.461C13.1799 18.3907 13.2194 18.2953 13.2194 18.1958V16.0103C13.2194 15.9109 13.1799 15.8155 13.1095 15.7452C13.0392 15.6748 12.9442 15.6353 12.8448 15.6353ZM12.4698 17.8208H10.7999V16.3853H12.4694L12.4698 17.8208ZM18.1656 15.6353H15.7461C15.6467 15.6353 15.5513 15.6748 15.481 15.7452C15.4106 15.8155 15.3711 15.9109 15.3711 16.0103V18.1958C15.3711 18.2953 15.4106 18.3907 15.481 18.461C15.5513 18.5313 15.6467 18.5708 15.7461 18.5708H18.166C18.2655 18.5708 18.3608 18.5313 18.4312 18.461C18.5015 18.3907 18.541 18.2953 18.541 18.1958V16.0103C18.541 15.9109 18.5015 15.8155 18.4312 15.7452C18.3608 15.6748 18.2651 15.6353 18.1656 15.6353ZM17.7906 17.8208H16.1211V16.3853H17.791L17.7906 17.8208Z" fill="#1C274C"/>
                                    </svg>
                                <span class="ms-2"></span>
                                <b class="caret ms-2"></b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="chart-container">
                            <div id="weeklyUserBarChartContainer">
                                <canvas id="weeklyUserBarChart" height="200" width="905"
                                        style="display: block; width: 905px; height: 200px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 mt-8">
                    @if(getLogInUser() && getLoggedInUserRoleId() != getSuperAdminRoleId())
                        @include('whatsapp_stores.sub_analytics')
                    @else
                        @include('sadmin.whatsapp_stores.sub_analytics')
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if($partName == 'overview')
                                <div class="col-12 col-lg-6 my-3">
                                    <div class="card border">
                                        <div class="card-body pb-4">
                                            <h3 class="h5">{{__('messages.analytics.countries')}}</h3>
                                            @foreach($data['country'] as $name => $country)
                                                @if($loop->index < 5)
                                                    <div class="mt-4">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <div class="text-truncate">
                                                                <span class="me-2">
                                                                    @if(file_exists('vendor/blade-flags/country-'.getCountryShortCode($name).'.svg'))
                                                                        <img src="{{ asset('vendor/blade-flags/country-'.getCountryShortCode($name).'.svg') }}" width="25" height="25"/>
                                                                    @endif
                                                                </span>
                                                                <a class="align-middle">{{$name}}</a>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted">{{round($country['per'])}}
                                                                    %</small>
                                                                <span class="ml-3">{{$country['count']}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress mb-3">
                                                            <div class="progress-bar bg-{{getRandColor()}}"
                                                                 role="progressbar" style="width: {{$country['per']}}%;"
                                                                 aria-valuenow="{{$country['per']}}" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>

                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="px-9 pt-2 pb-5">
                                            @if(getLogInUser() && getLoggedInUserRoleId() != getSuperAdminRoleId())
                                                <a href="{{config('app.url')}}/admin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=country"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @else
                                                <a href="{{config('app.url')}}/sadmin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=country"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body pb-3">
                                            <h3 class="h5">{{__('messages.analytics.devices')}}</h3>
                                            <p></p>

                                            @foreach($data['device'] as $name => $device)
                                                @if($loop->index < 5)
                                                    <div class="mt-4">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <div class="text-truncate">
                                                                <span>{{(ucfirst($name))}}</span>
                                                            </div>

                                                            <div>
                                                                <small class="text-muted">{{round($device['per'])}}
                                                                    %</small>
                                                                <span class="ml-3">{{$device['count']}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="progress mb-3">
                                                            <div class="progress-bar bg-{{getRandColor()}}"
                                                                 role="progressbar" style="width: {{$device['per']}}%;"
                                                                 aria-valuenow="{{$device['per']}}" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>

                                                    </div>
                                                @endif
                                            @endforeach

                                        </div>

                                        <div class="px-9 pt-2 pb-5">
                                            @if(getLogInUser() && getLoggedInUserRoleId() != getSuperAdminRoleId())
                                                <a href="{{config('app.url')}}/admin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=device"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @else
                                                <a href="{{config('app.url')}}/sadmin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=device"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body pb-4">
                                            <h3 class="h5">{{__('messages.analytics.os')}}</h3>
                                            <p></p>

                                            @foreach($data['operating_system'] as $name => $os)
                                                @if($loop->index < 5)
                                                    <div class="mt-4">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <div class="text-truncate">
                                                                <span>{{$name}}</span>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted">{{round($os['per'])}}%</small>
                                                                <span class="ml-3">{{$os['count']}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress mb-3">
                                                            <div class="progress-bar bg-{{getRandColor()}}"
                                                                 role="progressbar" style="width: {{$os['per']}}%;"
                                                                 aria-valuenow="{{$os['per']}}" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                        </div>

                                        <div class="px-9 pt-2 pb-5">
                                            @if(getLogInUser() && getLoggedInUserRoleId() != getSuperAdminRoleId())
                                                <a href="{{config('app.url')}}/admin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=os"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @else
                                                <a href="{{config('app.url')}}/sadmin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=os"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body pb-4">
                                            <h3 class="h5">{{__('messages.analytics.browsers')}}</h3>
                                            <p></p>

                                            @foreach($data['browser'] as $name => $browser)
                                                @if($loop->index < 5)
                                                    <div class="mt-4">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <div class="text-truncate">
                                                                <span>{{$name}}</span>
                                                            </div>

                                                            <div>
                                                                <small class="text-muted">{{round($browser['per'])}}
                                                                    %</small>
                                                                <span class="ml-3">{{$browser['count']}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="progress mb-3">
                                                            <div class="progress-bar bg-{{getRandColor()}}"
                                                                 role="progressbar" style="width: {{$browser['per']}}%;"
                                                                 aria-valuenow="{{$browser['per']}}" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                        </div>

                                        <div class="px-9 pt-2 pb-5">
                                            @if(getLogInUser() && getLoggedInUserRoleId() != getSuperAdminRoleId())
                                                <a href="{{config('app.url')}}/admin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=browser"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @else
                                                <a href="{{config('app.url')}}/sadmin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=browser"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body pb-4">
                                            <h3 class="h5">{{__('messages.analytics.languages')}}</h3>
                                            @foreach($data['language'] as $name => $language)
                                                @if($loop->index < 5)
                                                    <div class="mt-4">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <div class="text-truncate">
                                                                <span>{{ $name != '' ? \App\Models\User::ALL_LANGUAGES[$name] : ''}}</span>
                                                            </div>

                                                            <div>
                                                                <small class="text-muted">{{round($language['per'])}}
                                                                    %</small>
                                                                <span class="ml-3">{{$language['count']}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="progress mb-3">
                                                            <div class="progress-bar bg-{{getRandColor()}}"
                                                                 role="progressbar"
                                                                 style="width: {{$language['per']}}%;"
                                                                 aria-valuenow="{{$language['per']}}" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                        </div>

                                        <div class="px-9 pt-2 pb-5">
                                            @if(getLogInUser() && getLoggedInUserRoleId() != getSuperAdminRoleId())
                                                <a href="{{config('app.url')}}/admin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=language"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @else
                                                <a href="{{config('app.url')}}/sadmin/whatsapp-stores/{{$data['whatsappStoreID']}}/analytics?part=language"
                                                   class="text-muted">{{__('messages.analytics.view_more')}}</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($partName == 'country')
                                <div class="col-12 my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body">
                                            <h3 class="h5">{{__('messages.analytics.countries')}}</h3>
                                            <p></p>
                                            @foreach($data['country'] as $name => $country)
                                                <div class="d-flex justify-content-between mb-1 mt-4">
                                                    <div class="text-truncate">
                                                        <span class="me-2">
                                                                    @if(file_exists('vendor/blade-flags/country-'.getCountryShortCode($name).'.svg'))
                                                                <img src="{{ asset('vendor/blade-flags/country-'.getCountryShortCode($name).'.svg') }}" width="25" height="25"/>
                                                            @endif
                                                        </span>
                                                        <a class="align-middle">{{$name}}</a>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted">{{round($country['per'])}}
                                                            %</small>
                                                        <span class="ml-3">{{$country['count']}}</span>
                                                    </div>
                                                </div>

                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-{{getRandColor()}}"
                                                         role="progressbar"
                                                         style="width: {{$country['per']}}%;"
                                                         aria-valuenow="{{$country['per']}}" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($partName == 'device')
                                <div class="col-12 my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body">
                                            <h3 class="h5">{{__('messages.analytics.devices')}}</h3>
                                            <p></p>

                                            @foreach($data['device'] as $name => $device)
                                                <div class="mt-4">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <div class="text-truncate">
                                                            <span>{{(ucfirst($name))}}</span>
                                                        </div>

                                                        <div>
                                                            <small class="text-muted">{{round($device['per'])}}
                                                                %</small>
                                                            <span class="ml-3">{{$device['count']}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-{{getRandColor()}}"
                                                             role="progressbar"
                                                             style="width: {{$device['per']}}%;"
                                                             aria-valuenow="{{$device['per']}}" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>
                                </div>
                            @endif
                            @if($partName == 'os')
                                <div class="col-12 my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body">
                                            <h3 class="h5">{{__('messages.analytics.os')}}</h3>
                                            <p></p>

                                            @foreach($data['operating_system'] as $name => $os)
                                                <div class="mt-4">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <div class="text-truncate">
                                                            <span>{{$name}}</span>
                                                        </div>

                                                        <div>
                                                            <small class="text-muted">{{round($os['per'])}}%</small>
                                                            <span class="ml-3">{{$os['count']}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-{{getRandColor()}}"
                                                             role="progressbar"
                                                             style="width: {{$os['per']}}%;"
                                                             aria-valuenow="{{$os['per']}}"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>
                                </div>
                            @endif
                            @if($partName == 'browser')
                                <div class="col-12 my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body">
                                            <h3 class="h5">{{__('messages.analytics.browsers')}}</h3>
                                            <p></p>

                                            @foreach($data['browser'] as $name => $browser)
                                                <div class="mt-4">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <div class="text-truncate">
                                                            <span>{{$name}}</span>
                                                        </div>

                                                        <div>
                                                            <small class="text-muted">{{round($browser['per'])}}
                                                                %</small>
                                                            <span class="ml-3">{{$browser['count']}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-{{getRandColor()}}"
                                                             role="progressbar"
                                                             style="width: {{$browser['per']}}%;"
                                                             aria-valuenow="{{$browser['per']}}" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>
                                </div>
                            @endif
                            @if($partName == 'language')
                                <div class="col-12  my-3">
                                    <div class="card h-100 border">
                                        <div class="card-body">
                                            <h3 class="h5">{{__('messages.analytics.languages')}}</h3>
                                            <p></p>
                                            @foreach($data['language'] as $name => $language)
                                                <div class="mt-4">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <div class="text-truncate">
                                                            <span>{{$name != '' ? (\App\Models\User::ALL_LANGUAGES[$name] ?? __('messages.analytic.unknown_language')) : ''}}</span>
                                                        </div>

                                                        <div>
                                                            <small class="text-muted">{{round($language['per'])}}
                                                                %</small>
                                                            <span class="ml-3">{{$language['count']}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-{{getRandColor()}}"
                                                             role="progressbar"
                                                             style="width: {{$language['per']}}%;"
                                                             aria-valuenow="{{$language['per']}}" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
