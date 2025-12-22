<?php

namespace App\Http\Controllers\API\Admin;

use Carbon\Carbon;
use App\Models\Nfc;
use App\Models\Vcard;
use App\Models\NfcOrders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;

class NfcCardAPIController extends AppBaseController
{
    public function getNfcCardList($id = null)
    {
        $query = NfcOrders::with('nfcTransaction', 'vcard', 'nfcCard')
            ->where('user_id', getLogInUserId());

        if ($id) {
            $query->where('id', $id);
        }

        $cards = $query->orderByDesc('id')->get()->map(function ($card) {
            return [
                'id' => $card->id,
                'name' => $card->name,
                'card_type' => $card->nfcCard->name ?? '',
                'vcard' => $card->vcard->name ?? '',
                'company_name' => $card->company_name,
                'address' => $card->address,
                'order_status' => NfcOrders::ORDER_STATUS_ARR[$card->order_status] ?? '',
                'created_at' => $card->created_at->format('d M, Y'),
                'payment_status' => NfcOrders::PAYMENT_STATUS_ARR[$card->nfcTransaction->status ?? null] ?? '',
                'payment_type' => NfcOrders::PAYMENT_TYPE_ARR[$card->nfcTransaction->type ?? null] ?? '',
                'logo' => optional($card->getMedia(NfcOrders::LOGO_PATH)->first())->getFullUrl(),
            ];
        });

        return $this->sendResponse($cards, 'Nfc Card List Retrieved Successfully');
    }

    public function getNfc()
    {
        $nfcs = Nfc::all()->map(function ($nfc) {
            $nfc->price =  $currency = getCurrencyIcon(getSuperAdminSettingValue('default_currency')) . $nfc->price;
            return $nfc;
        })->makeHidden(['updated_at', 'created_at', 'media']);

        return $this->sendResponse($nfcs, 'Nfcs Cards Retrieved Successfully');
    }

    public function getVcardList()
    {
        $vcards = Vcard::whereTenantId(getLogInTenantId())->where('status', Vcard::ACTIVE)->pluck('name', 'id')->toArray();

        return $this->sendResponse($vcards, 'Vcard List Retrieved Successfully');
    }

    public function getPaymentTypes()
    {
        $paymentTypes = getPaymentGateway();

        return $this->sendResponse($paymentTypes, 'Payment Types Retrieved Successfully');
    }
}
