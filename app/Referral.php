<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\diagnostic\Bill;
use App\ReferralPayment;
use App\Transation;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsEmergency;
use App\Models\hospital\ReferralCategory;

class Referral extends Model
{
    protected $fillable = ['name','designation','contact','email','user_id','referral_category_id'];

    public function bill(){
        return $this->hasMany(Bill::class,'referral_id');
    }
    public function payments(){
        return $this->hasMany(ReferralPayment::class,'referral_id');
    }
    public function transation(){
        return $this->hasMany(Transation::class, 'vendor_id');
    }
    public function admission(){
        return $this->hasOne(HmsAdmission::class);
    }
    public function emergency(){
        return $this->hasOne(HmsEmergency::class);
    }
    public function category(){
        return $this->belongsTo(ReferralCategory::class,'referral_category_id');
    }

}
