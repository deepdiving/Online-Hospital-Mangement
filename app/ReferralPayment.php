<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Referral;
use App\Transation;
class ReferralPayment extends Model
{
    protected $fillable = ['date','referral_id','trans_id','amount','module','description','user_id'];
    protected $table = 'diagon_referral_payments';

    public function referral(){
        return $this->belongsTo(Referral::class,'referral_id');
    }
    public function transation(){
        return $this->belongsTo(Transation::class,'trans_id');
    }

}
