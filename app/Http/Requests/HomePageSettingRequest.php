<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomePageSettingRequest extends FormRequest
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
        $rules['app_logo'] = 'nullable|mimes:jpg,jpeg,png';
        $rules['favicon'] = 'nullable|mimes:jpg,jpeg,png|dimensions:max_width=16,max_height=16';
        $rules['register_image'] = 'nullable|mimes:jpg,jpeg,png';
        $rules['dashboard_logo'] = 'nullable|mimes:jpg,jpeg,png|dimensions:max_width=60,max_height=60';

        return $rules;
    }
}
