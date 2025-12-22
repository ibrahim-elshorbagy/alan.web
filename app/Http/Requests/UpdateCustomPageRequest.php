<?php

namespace App\Http\Requests;

use App\Models\CustomPage;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomPageRequest extends FormRequest
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
            'title' => [
                'required',
                'max:30',
                Rule::unique('custom_pages', 'title')->ignore($this->route('id'))
            ],
            'slug' => [
                'required',
                Rule::unique('custom_pages', 'slug')->ignore($this->route('id'))
            ],
            'description' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keyword' => 'required',
        ];
    }
}
