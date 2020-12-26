<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AssetCategory;
use App\AssetLocation;
class AssetEquipment extends Model
{
    protected $fillable = ['item_name','description','model','identification_no','serial_number','current_status','received_date','acquisition_cost','condition','category_id','location_id','user_id'];


    public function category(){
        return $this->belongsTo(AssetCategory::class,'category_id');
    }

    
    public function location(){
        return $this->belongsTo(AssetLocation::class,'location_id');
    }

    public function user(){
        return $this->belongsTo(HrmEmployee::class,'user_id');
    }
}
