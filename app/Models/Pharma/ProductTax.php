<?php

namespace App\Models\Pharma;

use Illuminate\Database\Eloquent\Model;

class ProductTax extends Model
{
    protected $fillable = ['tax_name','slug','description','user_id','tax_amount'];
    protected $table = 'pharma_product_taxes';
    public function getRouteKeyName(){
        return 'slug';
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'id');
    }
}
