<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DueCollection;
use App\Patient;
use App\User;

class DueCollectionItem extends Model
{
    protected $fillable = ['date','amount','patient_id','due_collection_id','table_id','table','user_id','status'];

    public function duecollection(){
        return $this->belongsTo(DueCollection::class,'due_collection_id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'patient_id');
    }
    
}
