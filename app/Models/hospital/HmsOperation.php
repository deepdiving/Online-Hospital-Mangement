<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\User;

class HmsOperation extends Model
{
   protected $fillable = [
      'invoice',
      'slug',
      'date',
      'time',
      'operation_service_id',
      'operation_service_name',
      'operation_service_price',
      'discount',
      'grand_total',
      'paid_amount',
      'due',
      'change',
      'actual_amount',
      'due_collection',
      'remark',
      'status',
      'patient_id',
      'admission_id',
      'user_id',
   ];

   public function getRouteKeyName(){
      return 'slug';
  }

   public function patient(){
      return $this->belongsTo(Patient::class,'patient_id');
   }

   public function user(){
      return $this->belongsTo(User::class,'user_id');
   }





   // public function operationService(){
   //    return $this->belongsTo(Patient::class,'patient_id');
   // }




   
}