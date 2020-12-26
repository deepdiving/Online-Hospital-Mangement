<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AssetEquipment;
class AssetCategory extends Model
{
    protected $fillable = ['name','description','status','user_id'];

    public function equipment(){
        return $this->hasMany(AssetEquipment::class,'category_id');
    }

}
