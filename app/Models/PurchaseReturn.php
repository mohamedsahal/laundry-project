<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function details()
    {
        return $this->hasMany(PurchaseReturnDetail::class);
    }
    public function purchase_payments()
    {
        return $this->hasMany(PurchaseReturnPayment::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
