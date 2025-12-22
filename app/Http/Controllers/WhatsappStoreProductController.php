<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WpOrder;
use Laracasts\Flash\Flash;
use App\Models\WpOrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WhatsappStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsappStoreProduct;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\WpProductBuyRequest;
use App\Mail\WhatsappStoreProductOrderSendUser;
use App\Http\Requests\UpdateWhatsappProductRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\CreateWhatsappStoreProductRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class WhatsappStoreProductController extends AppBaseController
{
    public function store(CreateWhatsappStoreProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $input = $request->all();
            $access = WhatsappStore::findOrFail($input['whatsapp_store_id']);

            if (!$access->tenant_id == getLogInTenantId()) {
                return $this->sendError('Unauthorized.');
            }

            $product = WhatsappStoreProduct::create($input);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $product->newAddMedia($image)->toMediaCollection(
                        WhatsappStoreProduct::PRODUCT_IMAGES,
                        config('app.media_disc')
                    );
                }
            }

            DB::commit();

            return $this->sendSuccess(__('messages.flash.wp_product_create'));
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function edit(WhatsappStoreProduct $wpStoreProduct)
    {
        $access = $wpStoreProduct->tenant_id == getLogInTenantId();
        if (!$access) {
            return $this->sendError('Unauthorized.');
        }
        $wpStoreProduct->load(['currency', 'category']);

        return $this->sendResponse($wpStoreProduct, 'Product retrieved successfully.');
    }


    public function update(WhatsappStoreProduct $wpStoreProduct, UpdateWhatsappProductRequest $request)
    {

        $access = $wpStoreProduct->tenant_id == getLogInTenantId();

        if (!$access) {
            return $this->sendError('Unauthorized.');
        }

        $input = $request->all();

        $wpStoreProduct->update($input);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $wpStoreProduct->newAddMedia($image)->toMediaCollection(
                    WhatsappStoreProduct::PRODUCT_IMAGES,
                    config('app.media_disc')
                );
            }
        }

        return $this->sendSuccess(__('messages.flash.wp_product_update'));
    }


    public function destroy($id)
    {
        $product = WhatsappStoreProduct::findOrFail($id);

        try {

            $isDelete = $product->ordersItems()->whereHas('wpOrder', function ($query) {
                $query->whereIn('status', [WpOrder::PENDING, WpOrder::DISPATCHED]);
            })->exists();

            if ($isDelete) {
                return $this->sendError('Product has orders.');
            }

            if ($product->tenant_id != getLogInTenantId()) {
                return $this->sendError('Unauthorized.');
            }

            $product->clearMediaCollection(WhatsappStoreProduct::PRODUCT_IMAGES);
            $product->delete();

            return $this->sendSuccess('Product deleted successfully.');
        } catch (\Exception $e) {

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function destroyMedia($id)
    {
        $media = Media::findOrFail($id);

        if ($media->model_type != WhatsappStoreProduct::class) {
            return $this->sendError('Unauthorized.');
        }

        $media->delete();

        return $this->sendSuccess(__('messages.flash.product_image_delete'));
    }

    public function productBuy(WpProductBuyRequest $request)
    {

        if ($request->ajax()) {
            try {

                setLocalLang($request->language);

                DB::beginTransaction();
                $input = $request->except('products');

                $products = json_decode($request->input('products'), true);

                $alias = $request->url_alias;

                $whatsappStore = WhatsappStore::where('url_alias', $alias)->first();
                if (!$whatsappStore) {
                    abort(404);
                }

                $productNames = [];
                foreach ($products as $product) {
                    $storeProduct = WhatsappStoreProduct::find($product['id']);
                    if (!$storeProduct || $storeProduct->available_stock < $product['qty']) {
                        return $this->sendError( __('messages.flash.product_out_of_stock', ['name' => $storeProduct->name]));
                    }
                    $productNames[] = $storeProduct->name;
                }

                $orderID = Str::upper(Str::random(8));

                $input['order_id'] = $orderID;

                $wpOrder = WpOrder::create($input);

                foreach ($products as $product) {
                    $wpOrderItem = WpOrderItem::create([
                        'wp_order_id' => $wpOrder->id,
                        'product_id' => $product['id'],
                        'price' => $product['price'],
                        'qty' => $product['qty'],
                        'total_price' => $product['total_price'],
                    ]);
                }
                DB::commit();
                $storeProduct = WhatsappStoreProduct::find($product['id']);
                if ($storeProduct) {
                    $storeProduct->available_stock -= $product['qty'];
                    $storeProduct->save();
                }
                $wpOrder->load(['products.product.currency']);

                $orderMailData = [
                    'user_name' => $storeProduct->whatsappStore->tenant->user->full_name,
                    'customer_name' => $input['name'],
                    'product_name' => implode(', ', $productNames),
                    'phone' => $input['phone'],
                    'address' => $input['address'],
                    'order_date' => Carbon::now()->format('d M Y'),
                ];
                $tenant = $whatsappStore->tenant;
                $ownerUser = $tenant->user;
                $userId = $ownerUser->id;

                if (getUserSettingValue('product_order_send_mail_user', $userId)) {
                    if ($ownerUser->email) {
                        Mail::to($ownerUser->email)->send(new WhatsappStoreProductOrderSendUser($orderMailData,$whatsappStore->default_language,$whatsappStore->url_alias));
                    }
                }

                return $this->sendResponse($wpOrder, 'Order Created Successfully.');
            } catch (\Exception $e) {

                DB::rollBack();

                return $this->sendError($e->getMessage());
            }
        }
    }

    public function showOrder(WpOrder $wpOrder)
    {
        $access = $wpOrder->wpStore->tenant_id == getLogInTenantId();
        if (!$access) {
            Flash::error(__('Unauthorized.'));
            return redirect()->back();
        }
        $wpOrder->load(['products.product']);

        return $this->sendResponse($wpOrder, 'Order retrieved successfully.');
    }

    public function updateOrderStatus(Request $request, WpOrder $wpOrder)
    {
        $access = $wpOrder->wpStore->tenant_id == getLogInTenantId();
        if (!$access) {
            Flash::error(__('Unauthorized.'));
            return redirect()->back();
        }

        $status = $request->input('status');

        $wpOrder->update(['status' => $status]);
        if ($status == WpOrder::CANCELLED) {
            $wpOrderItem  = WpOrderItem::where('wp_order_id', $wpOrder->id)->first();
            $storeProduct = WhatsappStoreProduct::find($wpOrderItem->product_id);
            if ($storeProduct) {
                $storeProduct->available_stock += $wpOrderItem['qty'];
                $storeProduct->save();
            }
        }

        $wpOrder->load(['products.product.currency', 'wpStore:id,url_alias']);

        $baseUrl = config('app.url');


        return $this->sendResponse([$wpOrder, $baseUrl], 'Order status updated successfully.');
    }

    public function destroyOrder($id)
    {
        $whatsappStoreOrder = WpOrder::findOrFail($id);

        $whatsappStoreOrder->delete();

        return $this->sendSuccess(__('messages.flash.wp_order_delete'));
    }
}
