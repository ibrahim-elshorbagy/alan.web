<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\AppBaseController;
use Auth;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Modules\GoogleWallet\App\Services\DemoEventTicket;
use Illuminate\Support\Facades\Session;
use Modules\GoogleWallet\App\Models\WalletCard;
use Modules\GoogleWallet\App\Services\DemoFlight;
use Modules\GoogleWallet\App\Services\DemoGeneric;
use Modules\GoogleWallet\App\Services\DemoGiftCard;
use Modules\GoogleWallet\App\Services\DemoLoyalty;
use Modules\GoogleWallet\App\Services\DemoOffer;

class GoogleWalletAPIController extends AppBaseController
{

    public function index()
    {
        if (!moduleExists('GoogleWallet')) {
            return $this->sendError('Google Wallet module not found.');
        }

        $googleWalletDatas = WalletCard::where('user_id', FacadesAuth::id())->get();

        if ($googleWalletDatas->isEmpty()) { // Changed from !$googleWalletDatas
            return $this->sendError('No Google Wallet data found.');
        }

        $data = [];

        foreach($googleWalletDatas as $googleWalletData) {
            $data[] = [
                'id' => $googleWalletData->id,
                'type' => $googleWalletData->type,
                'link' => $googleWalletData->link,
                'user_id' => $googleWalletData->user_id,
                'created_at' => $googleWalletData->created_at,
            ];
        }

        return $this->sendResponse($data, 'Google Wallet Data retrieved successfully.');
    }

    public function genrateCard(Request $request)
    {
        if (!moduleExists('GoogleWallet')) {
            return $this->sendError('Google Wallet module not found.');
        }

        $data = $request->all();
        $issuerId = config('services.google_wallet.issuer_id');
        $classSuffix = 'ET' . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $googleWalletLink = null;

        // Check card_type and create card accordingly
        switch ($data['card_type']) {
            case '0': // Event Ticket
                $demoEventTicket = new DemoEventTicket();
                $googleWalletLink = $demoEventTicket->createJwtNewObjects($issuerId, $classSuffix, $classSuffix, $data);
                break;

            case '1': // Flight Card
                $demoFlight = new DemoFlight();
                $googleWalletLink = $demoFlight->createJwtNewObjects($issuerId, $classSuffix, $classSuffix, $data);
                break;

            case '2': // Offer Card
                $demoOffer = new DemoOffer();
                $googleWalletLink = $demoOffer->createJwtNewObjects($issuerId, $classSuffix, $classSuffix, $data);
                break;

            case '3': // Gift Card
                $demoGiftCard = new DemoGiftCard();
                $googleWalletLink = $demoGiftCard->createJwtNewObjects($issuerId, $classSuffix, $classSuffix, $data);
                break;

            case '4': // Loyalty Card
                $demoLoyalty = new DemoLoyalty();
                $googleWalletLink = $demoLoyalty->createJwtNewObjects($issuerId, $classSuffix, $classSuffix, $data);
                break;

            case '5': // Generic Card
                $demoGeneric = new DemoGeneric();
                $googleWalletLink = $demoGeneric->createJwtNewObjects($issuerId, $classSuffix, $classSuffix, $data);
                break;

            default:
                return $this->sendError('Invalid card type.');
        }

        if ($googleWalletLink === null) {
            return $this->sendError('Something went wrong. Please try again later.');
        }

        // Save WalletCard
        $walletCard = WalletCard::create([
            'type' => $data['card_type'],
            'link' => $googleWalletLink,
            'user_id' => Auth::id(),
        ]);

        // Return API response
        return $this->sendResponse([
            'id' => $walletCard->id,
            'type' => $walletCard->type,
            'link' => $walletCard->link,
            'user_id' => $walletCard->user_id,
        ], 'Google Wallet card created successfully.');
    }

    public function googleWalletLink()
    {
        $googleWalletLink = Session::get('googleWalletLink');
        // Session::forget('googleWalletLink');
        return view('googlewallet::google_wallet.link', compact('googleWalletLink'));
    }

    public function create()
    {
        setLocalLang(getCurrentLanguageName());
        $userThemeMode = Auth::user()->theme_mode;
        return view('googlewallet::google_wallet.create', compact('userThemeMode'));
    }
}
