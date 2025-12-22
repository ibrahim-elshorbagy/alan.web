<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    use HasFactory;
    protected $table = 'custom_pages';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'seo_title',
        'seo_description',
        'seo_keyword',
    ];
    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'status' => 'boolean',
        'seo_title' => 'string',
        'seo_description' => 'string',
        'seo_keyword' => 'string',
    ];
    public static $rules = [
        'title' => 'required',
        'slug' => 'required',
        'description' => 'required',
        'seo_title' => 'required',
        'seo_description' => 'required',
        'seo_keyword' => 'required',
    ];

}
