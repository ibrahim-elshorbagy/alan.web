<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $table = 'email_templates';

    protected $fillable = [
        'email_template_type',
        'email_template_subject',
        'email_template_content',
        'language_id',
    ];
    public static $rules = [
        'email_template_type' => 'required',
        'email_template_subject' => 'required',
        'email_template_content' => 'required',
        'language_id' => 'required',
    ];
}
