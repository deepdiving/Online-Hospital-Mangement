<?php

namespace App\Models\Pharma;
use App\Models\Pharma\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pharma\Purchase;
use App\Models\Pharma\Transation;
class Manufacturer extends Model
{
    protected $fillable = ['manufacturer_name', 'slug', 'email', 'phone', 'address', 'manufacturer_balance', 'user_id', 'status'];
    protected $table = 'pharma_manufacturers';
    public function getRouteKeyName(){
        return 'slug';
    }
    public function purchase(){
        return $this->hasMany(Purchase::class,'id');
    }

    public function porduct(){
        return $this->hasMany(Product::class,'manufacturer_id');
    }

    public function transation(){
        return $this->hasMany(Transation::class, 'vendor_id');
    }

}
