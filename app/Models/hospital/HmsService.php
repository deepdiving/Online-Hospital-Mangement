<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Models\hospital\HmsServiceCategory;
use App\Models\hospital\HmsGivenService;
use App\Models\hospital\HmsEmergencyService;

class HmsService extends Model
{
    protected $fillable = ['name','slug','price','status','service_category_id','user_id'];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function servicecategory(){
        return $this->belongsTo(HmsServiceCategory::class,'service_category_id');
    }

    // public function  (){ //it will be services
    //     return $this->hasMany(HmsGivenService::class);
    // }
    public function emergencyservice(){
        return $this->hasMany(HmsEmergencyService::class,'service_id');
    }
}
