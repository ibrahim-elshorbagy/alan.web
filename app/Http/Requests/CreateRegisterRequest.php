<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\RecaptchaV3Async;
use App\Services\RecaptchaV2Async;

class CreateRegisterRequest extends FormRequest
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
        $rules = User::$rules;
        if (getSuperAdminSettingValue('phone_number_required') == 1) {
            $rules['contact'] = 'required';
        }
        $rules['password'] = 'required|same:password_confirmation|min:8';
        $rules['term_policy_check'] = 'required';
        if (getSuperAdminSettingValue('captcha_enable')) {
            $rules['g-recaptcha-response'] = ['required', function ($attribute, $value, $fail) {
                if(getRecaptchaVersion() == 1) {
                    if (!verifyRecaptcha($value)) {
                        $fail(__('messages.placeholder.invalid_captcha'));
                    }
                } else {
                    $recaptchaService = new RecaptchaV3Async();
                    $promise = $recaptchaService->verifyAsync($value);
                    $promise->then(function ($isValid) use ($fail) {
                        if (!$isValid) {
                            $fail(__('messages.placeholder.invalid_captcha'));
                        }
                    })->wait();
                }
            }];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'term_policy_check.required' => __('messages.placeholder.agree_term'),
            'g-recaptcha-response.required' =>  __('messages.placeholder.required_captcha'),
            'referral_code.exists' => __('messages.placeholder.referral_code_invalid'),
        ];
    }
}
