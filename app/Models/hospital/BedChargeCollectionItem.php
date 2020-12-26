<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Models\hospital\BedChargeCollection;

class BedChargeCollectionItem extends Model
{
    protected $fillable = [
        'collection_date',
        'amount',
        'bed_charge_collection_id',
    ];

    public function bed_charge(){
        return $this->belongsTo(BedChargeCollection::class,'bed_charge_collection_id');
    }
}