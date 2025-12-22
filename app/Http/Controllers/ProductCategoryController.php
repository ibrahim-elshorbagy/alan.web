<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends AppBaseController
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'image' => 'required|file|image|mimes:jpg,jpeg,png|max:1024',
            ]);
            $input = $request->all();
            $productCategory = ProductCategory::create([
                'name' => $input['name'],
                'whatsapp_store_id' => $input['whatsappStoreId'],
            ]);

            if ($request->hasFile('image')) {
                $productCategory->newAddMedia($input['image'])->toMediaCollection(
                    ProductCategory::IMAGE,
                    config('app.media_disc')
                );
            }

            DB::commit();

            return $this->sendSuccess(__('messages.flash.product_category_create'));
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function edit(ProductCategory $productCategory)
    {
        $access = $productCategory->tenant_id == getLogInTenantId();
        if(!$access){
            return $this->sendError('Unauthorized.');
        }
        $productCategory->loadCount('products');

        return $this->sendResponse($productCategory, 'Product category retrieved successfully.');
    }



    public function update(ProductCategory $productCategory, Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'image' => 'file|image|mimes:jpg,jpeg,png|max:1024',
            ]);

            $access = $productCategory->tenant_id == getLogInTenantId();

            if(!$access){
                return $this->sendError('Unauthorized.');
            }

            $input = $request->all();
        if ($request->hasFile('image')) {
            $tempMedia = $productCategory->newAddMedia($input['image'])->toMediaCollection(
                ProductCategory::IMAGE,
                config('app.media_disc')
            );

            $productCategory->media()
                ->where('id', '!=', $tempMedia->id)
                ->where('collection_name', ProductCategory::IMAGE)
                ->delete();
        }

            $productCategory->update([
                'name' => $input['name'],
            ]);

            DB::commit();

            return $this->sendSuccess(__('messages.flash.product_category_update'));
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function show(ProductCategory $productCategory)
    {
        $access = $productCategory->tenant_id == getLogInTenantId();
        if(!$access){
            return $this->sendError('Unauthorized.');
        }

        return $this->sendResponse($productCategory, 'Product category retrieved successfully.');
    }

    public function destroy($id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        if($productCategory->tenant_id != getLogInTenantId()){
            return $this->sendError('Unauthorized.');
        }

        if ($productCategory->products()->exists()) {
            return $this->sendError('Product category in use.');
        }

        $productCategory->clearMediaCollection(ProductCategory::IMAGE);
        $productCategory->delete();

        return $this->sendSuccess('Product category deleted successfully.');
    }


}
