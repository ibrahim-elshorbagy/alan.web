<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = Product::$rules;
        $rules['product_icon'] =  'nullable|array';
        $rules['product_icon.*'] =  'mimes:jpg,jpeg,png';

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.string' => __('messages.vcard.product_name_string'),
            'currency_id.required_with' =>  __('messages.vcard.currency_id_required_with'),
        ];
    }
}
