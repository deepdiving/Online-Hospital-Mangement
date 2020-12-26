<?php

namespace App\Models\diagnostic;

use Illuminate\Database\Eloquent\Model;
use App\Models\diagnostic\DiagonTestCategory;
use App\Models\diagnostic\BillItem;
use App\Models\doctor\PreTestItem;

class DiagonTestList extends Model
{
    protected $fillable = ['name','price','count','test_category_id'];

    public function category(){
        return $this->belongsTo(DiagonTestCategory::class,'test_category_id');
    }
    // public function bill(){
    //     return $this->belongsTo(Bill::class);
    // }
    public function billitem(){
        return $this->hasMany(BillItem::class,'test_id');
    }

    public function pretest(){
        return $this->hasMany(PreTestItem::class,'diagon_test_id');
    }
}
