<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\AffiliateUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;

class AffiliationAPIController extends AppBaseController
{
    public function getAffiliation()
    {
        $currentPlan = getCurrentSubscription()->plan;

        if (! $currentPlan->planFeature->affiliation) {
            return $this->sendError('Affiliation feature is disabled.');
        }

        $currentUserId = Auth::id();
        $totalAmount = AffiliateUser::whereAffiliatedBy($currentUserId)->sum('amount');
        $currentAmount = currentAffiliateAmount($currentUserId);
        $affiliationUrl = url('/register?referral-code=' . getLogInUser()->affiliate_code);
        $amount = getSuperAdminSettingValue('affiliation_amount_type') == 1
            ? currencyFormat(getSuperAdminSettingValue('affiliation_amount'))
            : getSuperAdminSettingValue('affiliation_amount') . '%';

        $note = "Note: Your affiliate links will be displayed at the bottom of your vCards page. When someone registers through your link and then purchases a subscription, you will be rewarded with {$amount}.";

        $data[] = [
            'affiliation_url' => $affiliationUrl,
            'total_amount' => $totalAmount,
            'current_amount' => $currentAmount,
            'note' => $note,
            'how_it_works' => getSuperAdminSettingValue('how_it_works'),
        ];

        return $this->sendResponse($data, 'Affiliation data retrieved successfully.');
    }

    public function getAffiliationList()
    {
        $data = AffiliateUser::with('user', 'affiliated_by_user')->whereAffiliatedBy(getLogInUserId())->orderBy('id', 'desc')->get();

        return $this->sendResponse($data, 'Affiliation data retrieved successfully.');
    }

    public function getWithdrawalList()
    {
        $data = Withdrawal::with('user')->whereUserId(getLogInUserId())->orderBy('id', 'desc')->get();

        return $this->sendResponse($data, 'Withdrawal data retrieved successfully.');
    }

    public function withdrawalRequest(Request $request)
    {
        
    }
}
