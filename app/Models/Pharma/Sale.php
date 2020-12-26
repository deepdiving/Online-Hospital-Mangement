<?php

namespace App\Models\Pharma;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\Models\Pharma\SaleItems;
use App\Models\Pharma\SaleReturn;

class Sale extends Model
{
    protected $guarded = [];
    protected $table = 'pharma_sales';
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function saleItems()
    {
        return $this->hasMany(SaleItems::class);
    }
}
