<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsService;

class HmsGivenService extends Model
{
    
    protected $fillable = ['admission_id','service_id','service_name','patient_id','service_price','service_date','user_id','status'];
    protected $table ="hms_given_services";

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function admission(){
        return $this->belongsTo(HmsAdmission::class,'admission_id');
    }
    public function service(){
        return $this->belongsTo(HmsService::class,'service_id');
    }
}
