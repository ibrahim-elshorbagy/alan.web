<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    $routeParam = $this->route('user') ?: ($this->route('admin') ?: $this->route('sales_user'));
    // Handle route model binding: if param is User model, extract id
    $requestId = is_object($routeParam) ? ($routeParam->id ?? $routeParam->getKey() ?? null) : $routeParam;
    $rules = User::$rules;
    $rules['profile'] = 'mimes:jpg,bmp,png,apng,avif,jpeg,';
    $rules['email'] = 'nullable|email:filter|max:191|unique:users,email,' . $requestId;
    $rules['contact'] = 'nullable|unique:users,contact,' . $requestId;

    return $rules;
  }
}
