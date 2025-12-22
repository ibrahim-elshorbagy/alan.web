<?php

namespace App\Http\Requests;

use App\Models\ContactRequest;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateContactEnquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        setLocalLang(getLocalLanguage());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = ContactRequest::$rules;

        if (Auth::check()) {
            $rules['phone'] = 'nullable|numeric';
            $rules['email'] = ['nullable'];
        }
        return $rules;
    }
}
