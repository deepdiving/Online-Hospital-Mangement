<?php

namespace App\Models\diagnostic;

use Illuminate\Database\Eloquent\Model;
use App\Models\diagnostic\DiagonTestList;

class DiagonTestCategory extends Model
{
    protected $fillable = ['category','commission'];

    public function tests(){
        return $this->hasMany(DiagonTestList::class,'test_category_id');
    }
}
