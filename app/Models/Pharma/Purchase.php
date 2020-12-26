<?php

namespace App\Models\Pharma;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pharma\Manufacturer;
use App\Models\Pharma\PurchaseItem;
use App\Models\Pharma\PurchaseReturn;
class Purchase extends Model
{
    protected $fillable = ['id','date','invoice','slug','description','purchase_amount','tax_percent','grand_total','trans_id','discount','payable_amount','user_id','manufacturer_id','status'];
    protected $table = 'pharma_purchases';
    public function getRouteKeyName(){
        return 'slug';
    }
    public function manufacturer(){
    	return $this->belongsTo(Manufacturer::class,'manufacturer_id');
    }

    public function purchaseItems(){
        return $this->hasMany(PurchaseItem::class);
    }
}