<?php

namespace App\Models\doctor;

use App\Patient;
use App\Doctor;
use App\Models\doctor\DocSchedule;

use Illuminate\Database\Eloquent\Model;

class DocAppointment extends Model{
    protected $fillable = [
        'date',
        'invoice',
        'patient_id',
        'doctor_id',
        'doc_schedule_id',
        'referral_id',
        'trans_id',
        'doctor_fees',
        'discount',
        'net_fees',
        'serial',
        'remark',
        'status',
        'user_id'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function docschedule(){
        return $this->belongsTo(DocSchedule::class,'doc_schedule_id');
    }
}
