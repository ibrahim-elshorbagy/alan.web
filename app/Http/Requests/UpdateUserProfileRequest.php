<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserProfileRequest extends FormRequest
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
    $id = Auth::id();

    $rules = User::$rules;
    $rules['email'] = $rules['email'] . $id;
    $rules['profile'] = 'mimes:jpg,bmp,png,apng,avif,jpeg,';

    // Only require contact if user has neither email nor phone
    $user = Auth::user();
    if (empty($user->email) && empty($user->contact)) {
      $rules['contact'] = 'required|unique:users,contact,' . $id;
    } else {
      $rules['contact'] = 'nullable|unique:users,contact,' . $id;
    }

    return $rules;
  }
}
