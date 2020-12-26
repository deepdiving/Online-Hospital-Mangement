<?php

namespace App\Models\Pharma;
use App\Models\Pharma\Product;
use App\Models\Pharma\Sale;
use App\Models\Pharma\Batch;
use Illuminate\Database\Eloquent\Model;

class SaleItems extends Model
{
    protected $guarded = [];
    protected $table = 'pharma_sale_items';
    public function sale(){
        return $this->belongsTo(Sale::class,'sale_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function batch(){
        return $this->belongsTo(Batch::class);
    }
}
