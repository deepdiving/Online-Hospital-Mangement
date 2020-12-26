<?php

namespace App\Models\doctor;

use Illuminate\Database\Eloquent\Model;
use App\Doctor;
use App\Models\doctor\DocAppointment;
class DocSchedule extends Model
{
    protected $fillable = [
        'name',
        'doctor_fees',
        'week_day',
        'start_time',
        'end_time',
        'visit_qty',
        'doctor_id',
        'user_id',
        'status'
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
    public function appointment(){
        return $this->hasOne(DocAppointment::class,'doc_schedule_id');
    }
}
