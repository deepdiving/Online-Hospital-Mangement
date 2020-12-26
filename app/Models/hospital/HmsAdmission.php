<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Models\hospital\HmsBed;
use App\Patient;
use App\Referral;
use App\Models\hospital\HmsGivenService;
use App\User;


class HmsAdmission extends Model
{
    protected $fillable = ['slug','date','invoice','admit_date','admit_time','sub_total','discount_percent','discount_overall','discount_total','grand_total','paid_amount','actual_paid_amount','due','change','discharge_date','discharge_time','remark','bed_id','patient_id','user_id','referral_id','is_discharge','status'];

   public function getRouteKeyName(){
        return 'slug';
    }
    public function bed(){
       return $this->belongsTo(HmsBed::class,'bed_id');
   }
   public function patient(){
       return $this->belongsTo(Patient::class,'patient_id');
   }
   public function referral(){
       return $this->belongsTo(Referral::class,'referral_id');
   }
   public function given_services(){
       return $this->hasMany(HmsGivenService::class,'admission_id');
   }
   public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}