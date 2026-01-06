<?php

namespace App\Http\Controllers;

use App\Models\RedirectLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminRedirectLinkRedeemMail;
use Laracasts\Flash\Flash;
use App\Enums\RedirectLinkTypeEnum;

class ClientRedirectLinkController extends Controller
{
  public function index()
  {
    return view('client.redirect_links.index');
  }

  public function edit($id)
  {
    $redirectLink = RedirectLink::where('user_id', auth()->id())->findOrFail($id);

    return view('client.redirect_links.edit', compact('redirectLink'));
  }

  public function update(Request $request, $id)
  {
    $redirectLink = RedirectLink::where('user_id', auth()->id())->findOrFail($id);

    $validator = Validator::make($request->all(), [
      'redirect_link' => [
        'nullable',
        'url',
        function ($attribute, $value, $fail) use ($redirectLink) {
          if ($value) {
            $type = $redirectLink->redirect_link_type;
            switch ($type) {
              case RedirectLinkTypeEnum::WEBSITE->value:
                // Any URL is allowed for website
                break;
              case RedirectLinkTypeEnum::FACEBOOK->value:
                if (!preg_match('/^https?:\/\/(www\.)?facebook\.com/', $value)) {
                  $fail(__('messages.redirect_links.invalid_facebook_url'));
                }
                break;
              case RedirectLinkTypeEnum::INSTAGRAM->value:
                if (!preg_match('/^https?:\/\/(www\.)?instagram\.com/', $value)) {
                  $fail(__('messages.redirect_links.invalid_instagram_url'));
                }
                break;
              case RedirectLinkTypeEnum::TIKTOK->value:
                if (!preg_match('/^https?:\/\/(www\.)?tiktok\.com/', $value)) {
                  $fail(__('messages.redirect_links.invalid_tiktok_url'));
                }
                break;
              case RedirectLinkTypeEnum::TWITTER->value:
                if (!preg_match('/^https?:\/\/(www\.)?(twitter\.com|x\.com)/', $value)) {
                  $fail(__('messages.redirect_links.invalid_twitter_url'));
                }
                break;
              case RedirectLinkTypeEnum::LINKEDIN->value:
                if (!preg_match('/^https?:\/\/(www\.)?linkedin\.com/', $value)) {
                  $fail(__('messages.redirect_links.invalid_linkedin_url'));
                }
                break;
              case RedirectLinkTypeEnum::YOUTUBE->value:
                if (!preg_match('/^https?:\/\/(www\.)?youtube\.com/', $value)) {
                  $fail(__('messages.redirect_links.invalid_youtube_url'));
                }
                break;
              case RedirectLinkTypeEnum::WHATSAPP->value:
                if (!preg_match('/^https?:\/\/(wa\.me|api\.whatsapp\.com|web\.whatsapp\.com)/', $value)) {
                  $fail(__('messages.redirect_links.invalid_whatsapp_url'));
                }
                break;
              case RedirectLinkTypeEnum::SNAPCHAT->value:
                if (!preg_match('/^https?:\/\/(www\.)?snapchat\.com/', $value)) {
                  $fail(__('messages.redirect_links.invalid_snapchat_url'));
                }
                break;
              default:
                // For unknown types, allow any URL
                break;
            }
          }
        }
      ],
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $redirectLink->update($request->only(['redirect_link']));

    return redirect()->route('client.redirect-links.index')->with('success', __('messages.redirect_links.updated'));
  }

  public function redeem(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'redeem_code' => 'required|string|max:16',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
      DB::beginTransaction();

      // Find the redirect link by redeem code
      $redirectLink = RedirectLink::where('redeem_code', $request->redeem_code)->first();

      if (!$redirectLink) {
        Flash::error(__('messages.redirect_links.invalid_redeem_code'));
        return redirect()->route('client.redirect-links.index');
      }

      // Check if already redeemed
      if ($redirectLink->status == RedirectLink::STATUS_REDEEMED) {
        Flash::error(__('messages.redirect_links.code_already_redeemed'));
        return redirect()->route('client.redirect-links.index');
      }

      // Check if rejected
      if ($redirectLink->status == RedirectLink::STATUS_REJECTED) {
        Flash::error(__('messages.redirect_links.code_rejected'));
        return redirect()->route('client.redirect-links.index');
      }

      // Check if already has a user
      if ($redirectLink->user_id != null) {
        Flash::error(__('messages.redirect_links.code_already_assigned'));
        return redirect()->route('client.redirect-links.index');
      }

      // Get user and NFC card details
      $user = auth()->user();
      $nfcCard = $redirectLink->nfc;
      $redirectType = \App\Enums\RedirectLinkTypeEnum::from($redirectLink->redirect_link_type)->label();

      // Create completed paid NFC order (following exact pattern from NfcOrdersController)
      $input = [
        'user_id' => $user->id,
        'card_type' => $redirectLink->nfcs_id,
        'name' => $user->first_name . ' ' . $user->last_name,
        'designation' => $user->occupation ?? 'N/A',
        'phone' => $user->contact ?? '0000000000',
        'region_code' => $user->region_code ?? '+1',
        'email' => $user->email,
        'address' => $user->location ?? 'N/A',
        'quantity' => 1,
        'company_name' => $user->company ?? 'N/A',
        'vcard_id' => null, // No vcard linked
        'order_status' => \App\Models\NfcOrders::DELIVERED, // Already delivered (redeemed)
      ];

      $nfcOrder = \App\Models\NfcOrders::create($input);

      // Create paid transaction record
      \App\Models\NfcOrderTransaction::create([
        'nfc_order_id' => $nfcOrder->id,
        'type' => \App\Models\NfcOrders::MANUALLY, // Paid manually outside the system
        'transaction_id' => 'REDEEM-' . $redirectLink->redeem_code,
        'amount' => $nfcCard->price ?? 0,
        'user_id' => $user->id,
        'status' => \App\Models\NfcOrders::SUCCESS, // Already paid
      ]);

      // Assign redirect link to user and mark as redeemed
      $redirectLink->update([
        'user_id' => $user->id,
        'status' => RedirectLink::STATUS_REDEEMED,
        'nfc_order_id' => $nfcOrder->id,
      ]);

      // Send email to admin
      Mail::to(getSuperAdminSettingValue('email'))->send(
        new AdminRedirectLinkRedeemMail($redirectLink, $user, $nfcCard, $redirectType)
      );

      DB::commit();

      Flash::success(__('messages.redirect_links.redeemed_successfully'));
      return redirect()->route('client.redirect-links.index');
    } catch (\Exception $e) {
      DB::rollBack();
      Flash::error(__('messages.redirect_links.redeem_failed') . ': ' . $e->getMessage());
      return redirect()->route('client.redirect-links.index');
    }
  }
}
