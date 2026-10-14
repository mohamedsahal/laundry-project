<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'usage_date',
        'product_id',
        'quantity',
        'unit_cost',
        'total_cost',
        'note',
        'financial_year_id',
        'created_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
