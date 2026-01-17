<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\RecaptchaV3Async;
use App\Services\RecaptchaV2Async;

class CreateRegisterRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  protected function prepareForValidation()
  {
    // Normalize phone if present
    if ($this->filled('contact')) {
      $this->merge([
        'contact' => normalizePhoneNumber($this->contact),
      ]);
    }

    // Convert empty email to null
    if (!$this->filled('email')) {
      $this->merge(['email' => null]);
    }

    // Convert empty contact to null
    if (!$this->filled('contact')) {
      $this->merge(['contact' => null]);
    }
  }


  public function rules(): array
  {
    $rules = User::$rules;

    $registerType = $this->input('register_type', 'email');

    if ($registerType === 'email') {
      $rules['email'] = 'required|email:filter|max:191|unique:users,email';
      $rules['contact'] = 'nullable|unique:users,contact';
    } elseif ($registerType === 'phone') {
      $rules['email'] = 'nullable|email:filter|max:191|unique:users,email';
      $rules['contact'] = 'required|unique:users,contact|regex:/^(00962|962)7[789]\d{7}$/';
    } else {
      $rules['email'] = 'required_without:contact|nullable|email:filter|max:191|unique:users,email';
      $rules['contact'] = 'required_without:email|nullable|unique:users,contact';
    }

    $rules['password'] = 'required|same:password_confirmation|min:8';
    $rules['term_policy_check'] = 'required';

    if (getSuperAdminSettingValue('captcha_enable')) {
      $rules['g-recaptcha-response'] = [
        'required',
        function ($attribute, $value, $fail) {
          if (getRecaptchaVersion() == 1) {
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
        }
      ];
    }

    return $rules;
  }

  public function messages(): array
  {
    return [
      'email.required' => __('messages.user.email') . ' ' . __('messages.common.is_required'),
      'contact.required' => __('messages.common.phone') . ' ' . __('messages.common.is_required'),
      'email.required_without' => __('Either email or phone number is required.'),
      'contact.required_without' => __('Either email or phone number is required.'),
      'contact.regex' => __('Please enter a valid Jordan phone number starting with 00962 or 962 (e.g., 009627xxxxxxxx or 9627xxxxxxxx).'),
      'region_code.required_with' => __('Region code is required when providing a phone number.'),
      'term_policy_check.required' => __('messages.placeholder.agree_term'),
      'g-recaptcha-response.required' => __('messages.placeholder.required_captcha'),
      'referral_code.exists' => __('messages.placeholder.referral_code_invalid'),
    ];
  }
}
