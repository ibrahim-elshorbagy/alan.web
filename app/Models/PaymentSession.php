<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSession extends Model
{
    use HasFactory;
    protected $table = 'payment_sessions';

    protected $fillable = [
        'invoice_id',
        'tenant_id',
        'plan_id',
        'subscription_id',
        'amount',
        'custom_field_id',
        'payment_type',
        'user_id',
        'vcard_id',
        'currency',
        'meta',
    ];

    protected $casts = [
        'invoice_id' => 'string',
        'tenant_id' => 'string',
        'plan_id' => 'string',
        'subscription_id' => 'string',
        'amount' => 'decimal:2',
        'custom_field_id' => 'string',
        'payment_type' => 'string',
        'user_id' => 'string',
        'vcard_id' => 'string',
        'currency' => 'string',
    ];
}
