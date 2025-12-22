<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWhatsappStoreProductRequest;
use App\Models\WhatsappStore;
use App\Models\WhatsappStoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WPProductAPIController extends AppBaseController
{
    public function getProductList(WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $products = WhatsappStoreProduct::where('whatsapp_store_id', $whatsappStore->id)->get();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'category_name' => $product->category->name ?? null,
                'selling_price' => $product->selling_price,
                'net_price' => $product->net_price,
                'available_stock' => $product->available_stock,
            ];
        }

        return $this->sendResponse($data, 'Product retrieved successfully.');
    }

    public function store(CreateWhatsappStoreProductRequest $request)
    {
        $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);

        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        DB::beginTransaction();

        try {
            $product = WhatsappStoreProduct::create([
                'whatsapp_store_id' => $whatsappStore->id,
                'tenant_id' => $whatsappStore->tenant_id,
                'category_id'  => $request->category_id,
                'name' => $request->name,
                'currency_id' => $request->currency_id,
                'net_price' => $request->net_price,
                'selling_price' => $request->selling_price,
                'total_stock' => $request->total_stock,
                'available_stock' => $request->available_stock,
                'description' => $request->description,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $product
                        ->addMedia($file)
                        ->usingFileName(time() . rand(1000,9999) . '.' . $file->extension())
                        ->toMediaCollection(
                            WhatsappStoreProduct::PRODUCT_IMAGES,
                            config('app.media_disc')
                        );
                }
            }
            DB::commit();
            return $this->sendSuccess('Product created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function update(CreateWhatsappStoreProductRequest $request, WhatsappStoreProduct $product)
    {
        $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);

        if (!$whatsappStore || $whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        if ($product->tenant_id != getLogInTenantId()) {
            return $this->sendError('Unauthorized access to product.');
        }

        DB::beginTransaction();
        try {
            $product->update([
                'whatsapp_store_id' => $whatsappStore->id,
                'tenant_id' => $whatsappStore->tenant_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'currency_id' => $request->currency_id,
                'net_price' => $request->net_price,
                'selling_price' => $request->selling_price,
                'total_stock'=> $request->total_stock,
                'available_stock' => $request->available_stock,
                'description' => $request->description,
            ]);

            if ($request->hasFile('images')) {

                $product->clearMediaCollection(WhatsappStoreProduct::PRODUCT_IMAGES);
                foreach ($request->file('images') as $file) {
                    $product
                        ->addMedia($file)
                        ->usingFileName(time() . rand(1000,9999) . '.' . $file->extension())
                        ->toMediaCollection(
                            WhatsappStoreProduct::PRODUCT_IMAGES,
                            config('app.media_disc')
                        );
                }
            }

            DB::commit();
            return $this->sendSuccess('Product updated successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $product = WhatsappStoreProduct::find($id);

        if (!$product || $product->tenant_id != getLogInTenantId()) {
            return $this->sendError('Product not found.');
        }

        try {
            $product->delete();
            return $this->sendSuccess('Product deleted successfully.');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function edit(WhatsappStoreProduct $product)
    {
        if ($product->tenant_id != getLogInTenantId()) {
            return $this->sendError('Product not found.');
        }

        $data = [
            'id' => $product->id,
            'whatsapp_store_id' => $product->whatsapp_store_id,
            'category_id' => $product->category->name ?? null,
            'name' => $product->name,
            'currency_id' => $product->currency->currency_name ?? null,
            'net_price' => $product->net_price,
            'selling_price' => $product->selling_price,
            'total_stock' => $product->total_stock,
            'available_stock' => $product->available_stock,
            'description' => $product->description,
            'images' => $product->getMedia(WhatsappStoreProduct::PRODUCT_IMAGES)->map(function ($media) {
                return $media->getFullUrl();
            })->toArray(),
        ];

        return $this->sendResponse($data, 'Product retrieved successfully.');
    }
}
