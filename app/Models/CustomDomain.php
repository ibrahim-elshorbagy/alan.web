<?php

namespace App\Models;

use App\Models\User;
use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomDomain extends Model
{
    use HasFactory,Multitenantable;

    protected $table = 'custom_domain';

    protected $fillable = [
        'domain',
        'user_id',
        'is_approved',
        'tenant_id',
        'is_active',
        'is_use_vcard',
        'note',
    ];

    const PENDING = 0;
    const APPROVED = 1;
    const REJECTED = 2;
    const ACTIVE = 1;
    const DISABLE = 0;

    const STATUS_ARR = [
        self::PENDING => 'Pending',
        self::APPROVED => 'Approved',
        self::REJECTED => 'Rejected',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
