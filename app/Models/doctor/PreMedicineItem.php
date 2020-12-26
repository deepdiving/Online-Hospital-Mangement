<?php

namespace App\Models\doctor;

use Illuminate\Database\Eloquent\Model;
use App\Models\doctor\PreMedicine;
use App\Models\doctor\Prescription;
class PreMedicineItem extends Model
{

    protected $fillable = [
        'medicine',
        'dose',
        'days',
        'use_time',
        'status',
        'prescription_id',
        'pre_medicine_id',
        'user_id'
    ]; 

    public function premedicine(){
        return $this->belongsTo(PreMedicine::class,'pre_medicine_id');
    }

    public function prescription(){       
        return $this->belongsTo(Prescription::class);
    }
}
