<?php

namespace App\Models\Pharma;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pharma\Product;
class Category extends Model{
    protected $fillable = ['name','slug','description','status','user_id'];
    protected $table = 'pharma_categories';
    public function getRouteKeyName(){
        return 'slug';
    }

    public function product(){
        return $this->hasMany(Product::class);
    }
}
