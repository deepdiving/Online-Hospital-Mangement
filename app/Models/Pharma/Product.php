<?php

namespace App\Models\Pharma;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pharma\Category;
use App\Models\Pharma\ProductType;
use App\Models\Pharma\Unit;
use App\Models\Pharma\Manufacturer;
use App\Models\Pharma\PurchaseItem;
use App\Models\Pharma\SaleItems;
use App\Models\Pharma\Batch;
class Product extends Model{
    protected $fillable = ['id','title','slug','generic_name','note','box_size','image','tax','purchase_price','sale_price','opening_stock','stock','shelf_no','category_id','user_id','unit_id','product_type_id','manufacturer_id','status'];
    protected $table = 'pharma_products';
    public function getRouteKeyName(){
        return 'slug';
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function type(){
        return $this->belongsTo(ProductType::class,'product_type_id');
    }

    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class,'manufacturer_id');
    }
    
    public function purchaseItems(){
        return $this->hasMany(PurchaseItem::class,'product_id');
    }
    public function saleItems(){
        return $this->hasMany(SaleItems::class);
    }
    public function batch(){
        return $this->hasMany(Batch::class);
    }
}