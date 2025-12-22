<?php

namespace App\Http\Requests;

use App\Models\WhatsappStoreEmailSubscription;
use Illuminate\Foundation\Http\FormRequest;

class CreateWhatsappStoreEmailSubscribersRequest extends FormRequest
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
        return WhatsappStoreEmailSubscription::$rules;
    }

    public function messages(): array
    {
        return [
            'email' => (__('messages.flash.email_required')),
        ];
    }

}
