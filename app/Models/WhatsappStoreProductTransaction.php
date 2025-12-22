<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappStoreProductTransaction extends Model
{
    use HasFactory;

    public function whatsappStore(){
        return $this->belongsTo(WhatsappStore::class);
    }
}
