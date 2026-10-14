<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'service_id',
        'service_name',
        'service_price',
        'service_quantity',
        'service_detail_total',
        'color_code'
    ];
}
