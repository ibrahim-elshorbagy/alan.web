<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
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
        $langParam = $this->route('language') ?? $this->route('languages');
        $langId = is_object($langParam) ? ($langParam->id ?? $langParam->getKey()) : $langParam;
        // fallback to route()->id if param not found (legacy)
        if (empty($langId)) {
            $route = $this->route();
            $langId = is_object($route) && isset($route->id) ? $route->id : null;
        }
        $rules['name'] = 'required|max:20|unique:languages,name,'.$langId;
        $rules['iso_code'] = 'required|max:2|min:2|unique:languages,iso_code,'.$langId;

        return $rules;
    }

    public function messages(): array
    {
        $messages['iso_code.required'] = 'The ISO Code field is required.';

        return $messages;
    }
}
