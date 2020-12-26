<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\patient;
use App\User;
use App\DueCollectionItem;
use App\Models\diagnostic\Bill;

class DueCollection extends Model
{
    protected $fillable = ['date','trans_id','slug','invoice','amount','description','patient_id','user_id','module','sub_module','status'];

    public function patient(){
        return $this->belongsTo(patient::class,'patient_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function duecollectionitem(){
        return $this->hasMany(DueCollectionItem::class,'due_collection_id');
    }
    public function bill(){
        return $this->belongsTo(Bill::class,'patient_id');
    } 
}
