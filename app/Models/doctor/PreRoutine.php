<?php

namespace App\Models\doctor;

use Illuminate\Database\Eloquent\Model;
use App\Models\doctor\PreMedicineType;
class PreRoutine extends Model
{
    protected $fillable = ['name','pre_medicine_type_id','user_id','status'];

    public function premedicinetype(){
        return $this->belongsTo(PreMedicineType::class,'pre_medicine_type_id');
    }
}
