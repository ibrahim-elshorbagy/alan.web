<div class="d-flex align-items-center justify-content-end">
    <div>
        @if ($row->is_approved == \App\Models\Withdrawal::INPROCESS && !isAdmin())
            <button class="btn btn-sm btn-success dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown"
                aria-expanded="false" data-bs-boundary="viewport">
                {{ __('messages.affiliation.approval_status') }}
            </button>
            <ul class="dropdown-menu withdraw-approval-dropdown" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="#" data-amount="{{ currencyFormat($row->amount, 2) }}"
                        data-id="{{ $row->id }}"
                        id="approveWithdrawalBtn">{{ __('messages.affiliation.approve') }}</a>
                </li>
                <li><a class="dropdown-item" href="#" data-id="{{ $row->id }}"
                        id="rejectWithdrawalBtn">{{ __('messages.affiliation.reject') }}</a>
                </li>
            </ul>
        @endif
    </div>
    <div class="mx-5">
        <span id="showAffiliationWithdrawBtn" data-id="{{ $row->id }}" type="button" data-bs-toggle="tooltip"
            data-placement="top" data-bs-original-title="{{ __('messages.common.view') }}"><i
                class="fa-solid fa-eye text-info"></i></span>
    </div>
</div>
