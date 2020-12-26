<?php

namespace App\Models\hospital;
use App\Patient;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\hospital\HmsEmergencyService;
use App\Referral;
class HmsEmergency extends Model
{
    protected $fillable = ['slug','date','invoice','time','sub_total','discount_percent','discount_overall','discount_total','grand_total','paid_amount','actual_paid_amount','due','due_collection','change','remark','patient_id','user_id','trans_id','referral_id','status'];
    
    public function getRouteKeyName(){
        return 'slug';
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function given_emergency_services(){
        return $this->hasMany(HmsEmergencyService::class,'hms_emergency_id');
    }
    public function referral(){
       return $this->belongsTo(Referral::class,'referral_id');
   }
}