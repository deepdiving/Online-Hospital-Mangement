<?php

namespace App\Models\laboratory;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Patient;
use App\Models\diagnostic\Bill;

class LabReport extends Model{
    protected $fillable = ['date','invoice','diagon_bill_id','content','patient_id','user_id','status'];

    public function getRouteKeyName(){
        return 'invoice';
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function bill(){
        return $this->belongsTo(Bill::class,'diagon_bill_id');
    }
}
