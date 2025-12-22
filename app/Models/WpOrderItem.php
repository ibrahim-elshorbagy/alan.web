<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpOrderItem extends Model
{
    use HasFactory;

    protected $table = 'wp_order_items';

    protected $fillable = [
        'wp_order_id',
        'product_id',
        'price',
        'qty',
        'total_price',
    ];

    public function product()
    {
        return $this->belongsTo(WhatsappStoreProduct::class, 'product_id');
    }

    public function wpOrder()
    {
        return $this->belongsTo(WpOrder::class, 'wp_order_id', 'id');
    }
}
