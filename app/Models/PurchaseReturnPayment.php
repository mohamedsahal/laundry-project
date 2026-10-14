<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnPayment extends Model
{
    use HasFactory;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchase_return()
    {
        return $this->belongsTo(PurchaseReturn::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
