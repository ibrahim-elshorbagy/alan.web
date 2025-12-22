<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $table = 'contact_requests';
    protected $fillable = [
        'name',
        'email',
        'region_code',
        'phone',
        'vcard_id',
        'user_id',
    ];

    public static $rules = [
        'name' => 'required|string|max:180',
        'email' => 'required|email|max:191|unique:contact_requests,email,',
        'phone' => 'required|numeric',
    ];
}
