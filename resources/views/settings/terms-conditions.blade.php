@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-md-flex">
            @include('settings.setting_menu')
            <div class="w-100">
            {{ Form::hidden('terms_condition_data',$setting['terms_conditions'],['id' => 'termConditionData']) }}
            {{ Form::hidden('privacy_policy_data',$setting['privacy_policy'],['id' => 'privacyPolicyData']) }}
            {{ Form::hidden('refund_cancellation_data',$setting['refund_cancellation'],['id' => 'refundCancellationsData']) }}
            {{ Form::hidden('shipping_delivery_data',$setting['shipping_delivery'],['id' => 'shippingDeliveriesData']) }}
            {{ Form::hidden('imprint_data',$setting['imprint'],['id' => 'imprintsData']) }}

            {{ Form::open(['route' => ['setting.TermsConditions.update'], 'method' => 'post','id' =>'TermsConditions']) }}

            <div class="col-lg-12">
                <div class="mb-5">
                    {{ Form::label('term_condition', __('messages.vcard.term_condition').':', ['class' => 'form-label']) }}
                    <div id="termConditionId"  class="editor-height" style="height: 200px"></div>
                    {{ Form::hidden('terms_conditions', null, ['id' => 'termData']) }}
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-5">
                    {{ Form::label('privacy_policy', __('messages.vcard.privacy_policy').':', ['class' => 'form-label']) }}
                    <div id="privacyPolicyId" class="editor-height" style="height: 200px"></div>
                    {{ Form::hidden('privacy_policy', null, ['id' => 'privacyData']) }}
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-5">
                    {{ Form::label('refund_cancellation', __('messages.vcard.refund_cancellation_policy').':', ['class' => 'form-label']) }}
                    <div id="refundCancellationId" class="editor-height" style="height: 200px"></div>
                    {{ Form::hidden('refund_cancellation', null, ['id' => 'refundCancellationData']) }}
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-5">
                    {{ Form::label('shipping_delivery', __('messages.vcard.shipping_delivery_policy').':', ['class' => 'form-label']) }}
                    <div id="shippingDeliveryId" class="editor-height" style="height: 200px"></div>
                    {{ Form::hidden('shipping_delivery', null, ['id' => 'shippingDeliveryData']) }}
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-5">
                    {{ Form::label('imprint', __('messages.vcard.imprint_policy').':', ['class' => 'form-label']) }}
                    <div id="imprintId" class="editor-height" style="height: 200px"></div>
                    {{ Form::hidden('imprint', null, ['id' => 'imprintData']) }}
                </div>
            </div>

            {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-3']) }}
            {{ Form::close() }}
        </div>
        </div>
    </div>
@endsection
