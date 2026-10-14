<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function calculateStock()
    {
        $totalPurchased = PurchaseDetail::where('product_id', $this->id)
            ->sum('quantity');

        $totalReturned = PurchaseReturnDetail::where('product_id', $this->id)
            ->sum('quantity');

        $totalUsed = StockUsage::where('product_id', $this->id)
            ->sum('quantity');

        $baseStock = $this->opening_stock ?? 0;
        $currentStock = $baseStock + $totalPurchased - $totalReturned - $totalUsed;
        return round($currentStock, 3);
    }

    /* weighted average cost of opening stock and all purchases, used to cost stock usage */
    public function averageCost()
    {
        $purchased = PurchaseDetail::where('product_id', $this->id)
            ->selectRaw('COALESCE(SUM(quantity), 0) as qty, COALESCE(SUM(rate * quantity), 0) as amount')
            ->first();
        $openingQty = $this->opening_stock ?? 0;
        $totalQty = $openingQty + $purchased->qty;
        if ($totalQty <= 0) {
            return (float) $this->purchase_price;
        }
        return round(($openingQty * $this->purchase_price + $purchased->amount) / $totalQty, 4);
    }
}
