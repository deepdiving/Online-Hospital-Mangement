<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Doctor;
use App\Transation;

class DoctorPayment extends Model
{
    protected $fillable = ['date','doctor_id','trans_id','amount','module','description','user_id'];
    protected $table = 'doctor_payments';

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    public function transation(){
        return $this->belongsTo(Transation::class,'trans_id');
    }
}
