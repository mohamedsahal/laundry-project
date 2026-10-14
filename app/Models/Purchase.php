<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'purchase_date',
        'purchase_number',
        'supplier_name',
        'supplier_id',
        'tax_type',
        'discount',
        'sub_total',
        'tax_percentage',
        'tax_amount',
        'taxable_amount',
        'total',
        'status',
        'notes',
        'total_quantity',
        'created_by',
        'financial_year_id',
    ];
    use HasFactory;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
    public function user()
       {
           return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
       }
}
