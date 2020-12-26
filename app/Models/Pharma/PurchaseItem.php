<?php

namespace App\Models\Pharma;
use App\Models\Pharma\Purchase;
use App\Models\Pharma\Product;
use App\Models\Pharma\Batch;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $table = 'pharma_purchase_items';
    public function purchase(){
        return $this->belongsTo(Purchase::class,'purchase_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function batch(){
        return $this->hasOne(Batch::class);
    }
}
