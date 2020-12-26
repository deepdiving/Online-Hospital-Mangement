<?php

namespace App\Models\diagnostic;

use Illuminate\Database\Eloquent\Model;
use App\Models\diagnostic\Bill;
use App\Models\diagnostic\DiagonTestList;
use App\Patient;

class BillItem extends Model
{
    protected $fillable = ['date','bill_id','test_id','test_price','user_id','patient_id'];
    protected $table = 'diagon_bill_items';

    public function bill(){
        return $this->belongsTo(Bill::class,'bill_id');
    }
    public function test(){
        return $this->belongsTo(DiagonTestList::class,'test_id');
    }
    public function patient(){
       return $this->belongsTO(Patient::class,'patient_id');
    }
}