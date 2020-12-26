<?php

namespace App\Models\doctor;

use Illuminate\Database\Eloquent\Model;
use App\Models\doctor\PreMedicine;
use App\Models\doctor\PreRoutine;

class PreMedicineType extends Model
{
    protected $fillable = ['name','status','user_id'];   

    public function premedicine(){
        return $this->hasMany(PreMedicine::class, 'pre_medicine_type_id');
    }

    public function preroutine(){
        return $this->hasMany(PreRoutine::class, 'pre_medicine_type_id');
    }
}
