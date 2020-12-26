<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\doctor\DocSchedule;
use App\User;
use App\Models\doctor\DocAppointment;
use App\DoctorPayment; 

class Doctor extends Model{

    protected $fillable = ['full_name','email','department_id','user_id','address','own_user_id','age','picture','gender','blood_group','designation','phone_no','mobile_no','biography','status'];

    public function schedule(){
        return $this->hasMany(DocSchedule::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function appointment(){
        return $this->hasOne(DocAppointment::class,'doctor_id');
    }
    public function docpayment(){
        return $this->hasMany(DoctorPayment::class,'doctor_id');
    }
    
}
