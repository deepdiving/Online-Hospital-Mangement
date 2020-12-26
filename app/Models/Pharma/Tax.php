<?php

namespace App\Models\Pharma;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'pharma_taxes';
    protected $fillable = ['id','date','sale_id','sale_invoice','amount','status','payment','user_id'];
}
