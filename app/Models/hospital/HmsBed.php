<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Models\hospital\HmsBedType;
use App\Models\hospital\HmsAdmission;
use App\Patient;

class HmsBed extends Model
{
    protected $fillable =['price','slug','bed_no','status','bed_status','bed_type_id','user_id'];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function bedtype(){
        return $this->belongsTo(HmsBedType::class,'bed_type_id');
    }

    public function admission(){
        return $this->hasOne(HmsAdmission::class,'bed_id');
    }

    public function rpatient(){
        return $this->belongsTo(Patient::class,'patient');
    }
}
