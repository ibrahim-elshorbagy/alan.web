<?php

namespace App\Http\Requests;

use App\Models\CustomPage;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomPageRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:30|unique:custom_pages,title',
            'slug' => 'required|unique:custom_pages,slug',
            'description' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keyword' => 'required',
        ];

    }
}
