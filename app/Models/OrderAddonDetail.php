<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddonDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'order_detail_id',
        'addon_id',
        'addon_name',
        'addon_price',
        'is_active'   
    ];
}
