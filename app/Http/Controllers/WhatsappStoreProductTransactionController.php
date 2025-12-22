<?php

namespace App\Http\Controllers;

use App\Models\WpOrder;
use Laracasts\Flash\Flash;
use App\Models\WpOrderItem;
use Illuminate\Http\Request;
use App\Models\WhatsappStoreProduct;

class WhatsappStoreProductTransactionController extends AppBaseController
{
    public function index()
    {
        return view('wp_product_transactions.index');
    }

    public function showOrder(WpOrder $wpProductOrder)
    {
        $access = $wpProductOrder->wpStore->tenant_id == getLogInTenantId();
        if (!$access) {
            Flash::error(__('Unauthorized.'));
            return redirect()->back();
        }
        $wpProductOrder->load(['products.product']);

        return $this->sendResponse($wpProductOrder, 'Order retrieved successfully.');
    }

    public function updateOrderStatus(Request $request, WpOrder $wpProductOrder)
    {
        $access = $wpProductOrder->wpStore->tenant_id == getLogInTenantId();
        if (!$access) {
            Flash::error(__('Unauthorized.'));
            return redirect()->back();
        }

        $status = $request->input('status');

        $wpProductOrder->update(['status' => $status]);
        if ($status == WpOrder::CANCELLED) {
            $wpOrderItem  = WpOrderItem::where('wp_order_id', $wpProductOrder->id)->first();
            $storeProduct = WhatsappStoreProduct::find($wpOrderItem->product_id);
            if ($storeProduct) {
                $storeProduct->available_stock += $wpOrderItem['qty'];
                $storeProduct->save();
            }
        }

        $wpProductOrder->load(['products.product.currency', 'wpStore:id,url_alias']);

        $baseUrl = config('app.url');

        return $this->sendResponse([$wpProductOrder, $baseUrl], __('messages.nfc.order_status_update_success'));
    }
}