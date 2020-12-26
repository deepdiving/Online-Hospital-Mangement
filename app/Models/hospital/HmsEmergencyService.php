<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Models\hospital\HmsEmergency;
use App\Models\hospital\HmsService;

class HmsEmergencyService extends Model
{
    protected $fillable = ['hms_emergency_id','service_date','service_id','service_name','patient_id','service_price','user_id','status'];

    public function emergency(){
        return $this->belongsTo(HmsEmergency::class,'hms_emergency_id');
    }
    public function service(){
        return $this->belongsTo(HmsService::class,'service_id');
    }
}