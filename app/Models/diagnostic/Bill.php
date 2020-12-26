<?php

namespace App\Models\diagnostic;

use Illuminate\Database\Eloquent\Model;
use App\Patient; 
use App\Models\diagnostic\BillItem;
use App\Models\laboratory\LabReport;
use App\Referral;
use App\User;
use App\DueCollection;

class Bill extends Model{
    protected $fillable = ['date','invoice','slug','delivary_date','delivary_time','description','sub_total','discount_percent','discount_overall','discount_total','grand_total','paid_amount','actual_paid_amount','due','change','user_id','referral_id','patient_id','trans_id','status'];
    protected $table = 'diagon_bills';

    public function getRouteKeyName(){
        return 'slug';
    }
    
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    } 
    public function billItem(){
        return $this->hasMany(BillItem::class,'bill_id');
    }
    public function referral(){
        return $this->belongsTo(Referral::class,'referral_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function duecollection(){
        return $this->hasMany(DueCollection::class,'patient_id');
    }

    public function labReports(){
        return $this->hasMany(LabReport::class,'diagon_bill_id');
    }


}