<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use App\Models\Product;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductTransaction;
use App\Http\Controllers\AppBaseController;
use App\Repositories\VcardProductRepository;

class ProductAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     */
    private $vcardProductRepo;

    public function __construct(VcardProductRepository $vcardProductRepo)
    {
        $this->vcardProductRepo = $vcardProductRepo;
    }

    public function index() {}

    public function getVcardProducts($vcardId)
    {

        $products = Product::where('vcard_id', $vcardId)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->get();


        if (empty($products)) {
            return $this->sendError('Product not found.');
        }
    
        $productsData = $products->map(function ($product) {
            $data = $product->makeHidden(['created_at', 'updated_at', 'media'])->toArray();
            $data['product_icon'] = $product->getMedia(Product::PRODUCT_PATH)
                ->map(function ($media) {
                    return $media->getFullUrl();
                })->toArray();
        
            return $data;
        });
        
        return $this->sendResponse($productsData, 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $rules = Product::$rules;
        $rules['vcard_id'] = 'required';
        $rules['product_icon.*'] = 'required|file|mimes:jpg,jpeg,png|max:2048';

        // $validator = validator()->make($request->all(), $rules);

        // if ($validator->fails()) {
        //     return $this->sendError($validator->errors()->first());
        // }

        // $vcard = Vcard::findOrFail($request->vcard_id);

        // if ($vcard->tenant_id != getLogInTenantId()) {
        //     return $this->sendError('Vcard not found.');
        // }
        $input = $request->all();

        $product = $this->vcardProductRepo->store($input);

        return $this->sendSuccess('Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $product = Product::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($product)) {
            return $this->sendError('Product not found.');
        }

        $data = $product->makeHidden(['created_at', 'updated_at', 'media'])->toArray();
        $data['product_icon'] = $product->getMedia(Product::PRODUCT_PATH)
            ->map(function ($media) {
                return $media->getFullUrl();
            })->toArray();

        return $this->sendResponse($data, 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = Product::$rules;
        $rules['product_icon.*'] = 'file|mimes:jpg,jpeg,png|max:2048';

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $product = Product::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($product)) {
            return $this->sendError('Product not found.');
        }

        $input = $request->all();

        $products = $this->vcardProductRepo->update($input, $id, true);

        return $this->sendSuccess('Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($product)) {
            return $this->sendError('Product not found.');
        }
        $product->delete();

        return $this->sendSuccess('Product deleted successfully.');
    }

    public function getCurrencyList()
    {
        $currecny = getCurrencies();

        return $this->sendResponse($currecny, 'Currency list retrieved successfully.');
    }

    public function getProductOrders($id = null)
    {
        $query = ProductTransaction::whereHas('product.vcard', function ($q) {
            $q->whereTenantId(getLogInTenantId());
        });
    
        if ($id) {
            $query->where('id', $id);
        }
    
        $orders = $query->latest()->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'product_name' => $order->product->name,
                'name' => $order->name,
                'order_at' => $order->created_at->format('d M Y'),
                'payment_type' => $order->type,
                'amount' => $order->currency->currency_icon . $order->amount,
                'type' => $order->type,
                'status' => $order->status,
                'email' => $order->email,
                'phone' => $order->phone,
                'address' => $order->address,
            ];
        });
    
        return $this->sendResponse($orders, 'Orders retrieved successfully.');
    }
    
}
