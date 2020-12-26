<?php

namespace App\Models\doctor;

use Illuminate\Database\Eloquent\Model;
use App\Models\doctor\PreMedicineType;
use App\Models\doctor\PreMedicineItem;
use App\User;
class PreMedicine extends Model
{
    protected $fillable = ['name','count','pre_medicine_type_id','user_id','status'];

    public function premedicinetype(){
        return $this->belongsTo(PreMedicineType::class,'pre_medicine_type_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function premedicineitem(){
        return $this->hasMany(PreMedicineItem::class, 'pre_medicine_id');
    }
}
