<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;
     /* user relation */
     public function user()
     {
         return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
     }
}
