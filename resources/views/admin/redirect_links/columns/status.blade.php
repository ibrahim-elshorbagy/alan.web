@if ($row->status == \App\Models\RedirectLink::STATUS_REDEEMED)
  <span class="badge badge-success">{{ __('messages.redirect_links.redeemed') }}</span>
@else
  <span class="badge badge-warning">{{ __('messages.redirect_links.not_redeemed') }}</span>
@endif
