<?php

namespace App\Http\Controllers;

use App\Models\ProductTransaction;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductTransactionController extends AppBaseController
{
    public function index()
    {
        return view('product_transactions.index');
    }

    public function show($id)
    {
        $productTransaction = ProductTransaction::whereId($id)->first();

        return view('product_transactions.show', compact('productTransaction'));
    }

    public function updateSendCustomerMail(Request $request)
    {
        $setting = UserSetting::where('user_id', Auth::id())->where('key', 'product_order_send_mail_customer')->first();
        try {
            DB::beginTransaction();
            if (! $setting) {
                $setting = UserSetting::create([
                    'user_id' => Auth::id(),
                    'key' => 'product_order_send_mail_customer',
                    'value' => $request->customer_mail ?? '1',
                ]);
            } else {
                $setting->update(['value' => $request->customer_mail ?? '1']);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }

        return $this->sendSuccess(__('messages.flash.send_email_to_customer_success'));
    }

    public function updateSendUserMail(Request $request)
    {
        $setting = UserSetting::where('user_id', Auth::id())->where('key', 'product_order_send_mail_user')->first();
        try {
            DB::beginTransaction();
            if (! $setting) {
                $setting = UserSetting::create([
                    'user_id' => Auth::id(),
                    'key' => 'product_order_send_mail_user',
                    'value' => $request->user_mail ?? '1',
                ]);
            } else {
                $setting->update(['value' => $request->user_mail ?? '1']);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }

        return $this->sendSuccess(__('messages.flash.send_email_to_user_success'));
    }
}
