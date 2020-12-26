<?php

namespace App\Models\doctor;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Doctor;
use App\Patient;
use App\Models\doctor\DocAppointment;
use App\Models\doctor\PreMedicineItem;
use App\Models\doctor\PreTestItem;

class Prescription extends Model
{
  
    protected $fillable = ['invoice','date','symptoms','diagnosis','advices','next_appointment','patient_id','appointment_id','doctor_id','status','user_id']; 

    public function getRouteKeyName(){
        return 'invoice';
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function appointment(){
        return $this->belongsTo(DocAppointment::class);
    }

    public function premedicineitem(){
        return $this->hasMany(PreMedicineItem::class, 'prescription_id');
    }

    public function pretest(){
        return $this->hasMany(PreTestItem::class, 'prescription_id');
    }
}


