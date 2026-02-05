<?php

namespace App\Http\Requests;

use App\Models\WhatsappStore;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWhatsappStoreRequest extends FormRequest
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
        $part = $this->input('part');

        if ($part === 'media-assets') {
            return [
                'logo' => 'nullable|file|mimes:jpg,png,jpeg',
                'cover_img' => 'nullable|file|mimes:jpg,png,jpeg',
                'selected_cover_image' => 'nullable|string',
                'slider_video_banner' => 'nullable|url',
            ];
        }

        $rules = WhatsappStore::$rules;
        $rules['logo'] = 'file|mimes:jpg,png,jpeg';
        $rules['cover_img'] = 'file|mimes:jpg,png,jpeg';
        $rules['url_alias'] = 'required|string|min:8|max:100|unique:whatsapp_stores,url_alias,' . $this->whatsappStore->id;
        return $rules;
    }
}
