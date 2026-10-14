<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_name',
        'phone_number',
        'order_date',
        'delivery_date',
        'sub_total',
        'addon_total',
        'discount',
        'tax_percentage',
        'tax_amount',
        'total',
        'note',
        'status',
        'order_type',
        'created_by',
        'financial_year_id'
    ];

    /* user relation */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    /* user relation */
    public function details()
    {
        return $this->hasMany(\App\Models\OrderDetail::class, 'order_id', 'id');
    }
    
    /* user relation */
    public function addons()
    {
        return $this->hasMany(\App\Models\OrderAddonDetail::class, 'order_id', 'id');
    }
}
