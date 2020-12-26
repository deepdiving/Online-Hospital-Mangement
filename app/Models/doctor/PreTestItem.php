<?php

namespace App\Models\doctor;

use Illuminate\Database\Eloquent\Model;
use App\Models\doctor\Prescription;
use App\Models\diagnostic\DiagonTestList;
class PreTestItem extends Model
{
    protected $fillable = ['test','diagon_test_id','prescription_id','status','user_id']; 

    public function prescription(){
        return $this->belongsTo(Prescription::class,'prescription_id');
    }

    public function diagontest(){
        return $this->belongsTo(DiagonTestList::class);
    }
}
