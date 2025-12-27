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
    $rules['favicon'] = 'nullable|mimes:jpg,jpeg,png';
    $rules['register_image'] = 'nullable|mimes:jpg,jpeg,png';
    $rules['dashboard_logo'] = 'nullable|mimes:jpg,jpeg,png';

    return $rules;
  }
}
