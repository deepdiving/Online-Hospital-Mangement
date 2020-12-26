<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model; 
use App\Models\hospital\HmsBed;

class HmsBedType extends Model
{
   protected $fillable = ['name','user_id','slug','status'];

   public function getRouteKeyName(){
        return 'slug';
    }

public function bed(){
   return $this->hasMany(HmsBed::class,'bed_type_id');
}

}
