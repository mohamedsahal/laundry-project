<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSettings extends Model
{
    use HasFactory;
    protected $fillable=['master_title','master_value'];
    public $timestamps = false;
    
        /* master settings value update settings */
        public function siteData(){
            $siteInfo=array();
            foreach($this->get() as $key=>$value){
                $siteInfo[$value['master_title']]=$value['master_value'];
            }
            return $siteInfo;
        }
}
