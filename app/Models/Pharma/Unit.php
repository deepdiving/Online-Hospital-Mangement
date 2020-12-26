<?php

namespace App\Models\Pharma;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pharma\Product;
class Unit extends Model
{
    protected $fillable = ['unit_name','slug','description','user_id'];
    protected $table = 'pharma_units';
    public function getRouteKeyName(){
        return 'slug';
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'id');
    }

    public function product(){
        return $this->hasMany(Product::class);
    }
}
