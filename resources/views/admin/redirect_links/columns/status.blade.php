@if ($row->status == \App\Models\RedirectLink::STATUS_REDEEMED)
  <span class="badge bg-success">{{ __('messages.redirect_links.redeemed') }}</span>
@else
  <span class="badge bg-warning text-dark">{{ __('messages.redirect_links.not_redeemed') }}</span>
@endif
