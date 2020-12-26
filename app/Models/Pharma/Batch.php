<?php

namespace App\Models\Pharma;
use App\Models\Pharma\PurchaseItem;
use App\Models\Pharma\Product;
use App\Models\Pharma\SaleItems;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['product_id','purchase_id','purchase_item_id','batch_number','in_stock','expiry_date','status'];
    protected $table = 'pharma_batches';
    public function purchaseItem(){
        return $this->belongsTo(PurchaseItem::class,'purchase_item_id');
    }
    public function saleItem(){
        return $this->hasOne(SaleItems::class);
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
