<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEcardRequest extends FormRequest
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
    $isWpStore = $this->input('source_type') === 'whatsapp_store';

    return [
      'vcard_id' => $isWpStore ? 'nullable' : 'required',
      'first_name' => 'required|max:10',
      'last_name' => 'required|max:10',
      'email' => 'required|email:filter',
      'occupation' => 'required|max:20',
      'phone' => 'required|numeric',
      'location' => 'required',
      'website' => 'required',
      'ecard-logo' => 'required|image|mimes:jpeg,png,jpg',
    ];
  }

  /**
   * Get the validation rules that apply to the request.
   */
  public function messages(): array
  {
    return [
      'vcard_id.required' => __('messages.common.vcard_name_required'),
    ];
  }
}
