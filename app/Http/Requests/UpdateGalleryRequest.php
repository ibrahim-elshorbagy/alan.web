<?php

namespace App\Http\Requests;

use App\Models\Gallery;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
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
        $rules = Gallery::$rules;

        $gallery = Gallery::whereId($this->route('gallery')->id)->first();

        $rule = 'mimes:jpg,png,jpeg,webp';
        $rule1 = 'file|mimes:txt,xls,xlsx,csv,xml,pdf,doc,docx';

        if ($gallery->type != $this->type) {
            $rule = 'required|mimes:jpg,png,jpeg,webp';
            $rule1 = 'required|file|mimes:txt,xls,xlsx,csv,xml,pdf,doc,docx';
        }

        if ($this->type == Gallery::TYPE_IMAGE) {
            $rules['image'] = $rule;
        }

        if ($this->type == Gallery::TYPE_FILE) {
            $rules['gallery_upload_file'] = $rule1;
        }

        if ($this->type == Gallery::TYPE_VIDEO) {
            $rules['video_file'] = 'file|mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040|required';
        }

        if ($this->type == Gallery::TYPE_AUDIO) {
            $rules['audio_file'] = 'mimes:mp3,wav,ogg|max:100040|required';
        }

        return $rules;
    }
}
