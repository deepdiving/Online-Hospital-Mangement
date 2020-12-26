<?php

namespace App\Models\Pharma;
use App\Models\Pharma\Product;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = ['type_name','slug','description','status','user_id'];
    protected $table = 'pharma_product_types';
    public function getRouteKeyName(){
        return 'slug';
    }

    public function product(){
        return $this->hasMany(Purchase::class,'product_type_id');
    }
}
