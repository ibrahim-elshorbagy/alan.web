<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\WhatsappStore;
use App\Models\WhatsappStoreProduct;
use App\Models\WpOrder;
use App\Models\WpOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class WPProductOrderAPIController extends AppBaseController
{
    public function getProductOrdersList(WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $wpProductOrders = WpOrder::with('wpStore', 'products')
            ->where('wp_store_id', $whatsappStore->id)
            ->orderBy('id', 'DESC')
            ->get();

        $data = [];

        foreach ($wpProductOrders as $order) {
            $data[] = [
                'id' => $order->id,
                'order_id'     => $order->order_id,
                'name'         => $order->name,
                'phone'        => $order->phone,
                'region_code'  => $order->region_code,
                'address'      => $order->address,
                'grand_total'  => $order->grand_total,
                'status'       => WpOrder::STATUS_ARR[$order->status],
                'products'     => $order->products,
            ];
        }

        return $this->sendResponse($data, 'Product order retrieved successfully.');
    }

    public function updateOrderStatus(Request $request, WpOrder $wpOrder)
    {
        $request->validate([
            'status' => 'required|in:1,2,3', // 1=Dispatched, 2=Delivered, 3=Cancelled
        ]);

        if ($wpOrder->wpStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Unauthorized access.');
        }

        DB::beginTransaction();
        try {
            $status = $request->status;

            $wpOrder->update(['status' => $status]);

            if ($status == WpOrder::CANCELLED) {
                $wpOrderItem = WpOrderItem::where('wp_order_id', $wpOrder->id)->first();
                $storeProduct = WhatsappStoreProduct::find($wpOrderItem->product_id);

                if ($storeProduct) {
                    $storeProduct->available_stock += $wpOrderItem->qty;
                    $storeProduct->save();
                }
            }

            DB::commit();

            return $this->sendSuccess('Order status updated successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(WpOrder $wpOrder)
    {
        if ($wpOrder->wpStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Unauthorized access.');
        }

        if (!in_array($wpOrder->status, [WpOrder::DELIVERED, WpOrder::CANCELLED])) {
            return $this->sendError('Order cannot be deleted until it is delivered or cancelled.');
        }

        try {
            $wpOrder->delete();
            return $this->sendSuccess('Order deleted successfully.');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
