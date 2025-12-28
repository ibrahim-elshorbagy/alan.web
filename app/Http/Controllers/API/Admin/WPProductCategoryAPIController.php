<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\WhatsappStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;

class WPProductCategoryAPIController extends AppBaseController
{

    public function getVcardProductCategories(WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $productCategories = ProductCategory::withCount('products')->where('whatsapp_store_id', $whatsappStore->id)->get();

        $data = [];

        foreach ($productCategories as $category) {
            $data[] = [
                'id' => $category->id,
                'name' => $category->name,
                'image_url' => $category->getFirstMediaUrl(
                    ProductCategory::IMAGE,
                    'thumb'
                ) ?: asset('assets/images/default_cover_image.jpg'),
                'product_count' => $category->products_count,
            ];
        }

        return $this->sendResponse($data, 'Product categories retrieved successfully.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
            'name' => 'required|string|max:191',
            'image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:1024',
        ], [
            'whatsapp_store_id.exists' => 'Invalid WhatsApp store ID.',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);

        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        DB::beginTransaction();

        try {
            $productCategory = ProductCategory::create([
                'name' => $request->name,
                'whatsapp_store_id' => $whatsappStore->id,
                'tenant_id' => $whatsappStore->tenant_id,
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $resizedImage = Image::make($file)->fit(100, 100);
                $tempPath = sys_get_temp_dir() . '/' . time() . '.' . $file->extension();
                $resizedImage->save($tempPath);
                $resizedFile = new UploadedFile($tempPath, $file->getClientOriginalName(), $file->getMimeType(), null, true);

                $productCategory
                    ->addMedia($resizedFile)
                    ->usingFileName(time() . '.' . $file->extension())
                    ->toMediaCollection(
                        ProductCategory::IMAGE,
                        config('app.media_disc')
                    );

                @unlink($tempPath);
            }
            DB::commit();
            return $this->sendSuccess('Product category created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
            'name' => 'required|string|max:191',
            'image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:1024',
        ], [
            'whatsapp_store_id.exists' => 'Invalid WhatsApp store ID.',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);

        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $productCategory = ProductCategory::where('id', $id)
            ->where('whatsapp_store_id', $whatsappStore->id)
            ->first();

        if (!$productCategory) {
            return $this->sendError('Product category not found.');
        }

        DB::beginTransaction();

        try {
            $productCategory->update([
                'name' => $request->name,
            ]);

            if ($request->hasFile('image')) {
                $productCategory->clearMediaCollection(ProductCategory::IMAGE);

                $file = $request->file('image');
                $resizedImage = Image::make($file)->fit(100, 100);
                $tempPath = sys_get_temp_dir() . '/' . time() . '.' . $file->extension();
                $resizedImage->save($tempPath);
                $resizedFile = new UploadedFile($tempPath, $file->getClientOriginalName(), $file->getMimeType(), null, true);

                $productCategory
                    ->addMedia($resizedFile)
                    ->usingFileName(time().'.'.$file->extension())
                    ->toMediaCollection(
                        ProductCategory::IMAGE,
                        config('app.media_disc')
                    );

                @unlink($tempPath);
            }

            DB::commit();
            return $this->sendSuccess('Product category updated successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $productCategory = ProductCategory::find($id);

        if (!$productCategory || $productCategory->tenant_id != getLogInTenantId()) {
            return $this->sendError('Product category not found.');
        }

        try {
            $productCategory->delete();
            return $this->sendSuccess('Product category deleted successfully.');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $productCategory = ProductCategory::find($id);

        if (!$productCategory || $productCategory->tenant_id != getLogInTenantId()) {
            return $this->sendError('Product category not found.');
        }

        $data = [
            'id' => $productCategory->id,
            'name' => $productCategory->name,
            'image_url' => $productCategory->getFirstMediaUrl(
                ProductCategory::IMAGE,
                'thumb'
            ) ?: asset('assets/images/default_cover_image.jpg'),
        ];

        return $this->sendResponse($data, 'Product category retrieved successfully.');
    }
}
