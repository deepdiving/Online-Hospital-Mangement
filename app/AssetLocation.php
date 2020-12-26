<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AssetEquipment;

class AssetLocation extends Model
{
    protected $fillable = ['name','description','status','user_id'];

    public function equipment(){
        return $this->hasMany(AssetEquipment::class,'location_id');
    }
}
