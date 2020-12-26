<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\Models\hospital\BedChargeCollectionItem;
use App\User;
class BedChargeCollection extends Model
{
    protected $fillable = [
        'slug',
        'date',
        'invoice',
        'sub_total',
        'discount',
        'grand_total',
        'paid_amount',
        'due',
        'advance',
        'remark',
        'bed_id',
        'patient_id',
        'admission_id',
        'user_id',
        'trans_id',
        'status',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    
    public function bed_charge_item(){
        return $this->hasMany(BedChargeCollectionItem::class,'bed_charge_collection_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}