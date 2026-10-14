<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_name',
        'icon',
        'icon_type',
        'is_active'
    ];

    public function image(){
        if($this->icon_type == 1){
            return asset('assets/img/service-icons/'.$this->icon);
        }
        else{
            return asset($this->icon);
        }
    }
}
