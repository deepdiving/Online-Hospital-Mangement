<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\Models\Pharma\Manufacturer;
use App\Referral;
use App\ExpenseCategory;
use App\ReferralPayment;
use App\DoctorPayment;
use App\User;
class Transation extends Model
{
    protected $fillable = ['date','trans_id','amount','description','transaction_way','bank_transaction_id','vendor_id','vendor','module','sub_module','transaction_type','status','user_id'];

    public function patient(){
        return $this->belongsTo(Patient::class, 'vendor_id');
    }
    public function referral(){
        return $this->belongsTo(Referral::class, 'vendor_id');
    }
    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class, 'vendor_id');
    }
    public function expenseCat(){
        return $this->belongsTo(ExpenseCategory::class, 'vendor_id');
    }

    public function referralPayment(){
        return $this->hasOne(ReferralPayment::class,'trans_id');
    }
    public function docpayment(){
        return $this->hasMany(DoctorPayment::class,'trans_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}