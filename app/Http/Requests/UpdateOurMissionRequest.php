<?php

namespace App\Http\Requests;

use App\Models\OurMission;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOurMissionRequest extends FormRequest
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
        return OurMission::$rules;
    }
}
