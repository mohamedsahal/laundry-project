<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
      /* expense category relation */
      public function expenseCategory()
      {
          return $this->belongsTo(\App\Models\ExpenseCategory::class, 'expense_category_id', 'id');
      }
  
       /* user relation */
       public function user()
       {
           return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
       }
}
