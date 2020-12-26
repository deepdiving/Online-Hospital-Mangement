<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Models\hospital\HmsService;

class HmsServiceCategory extends Model
{
    protected $fillable = ['name','slug','status','user_id'];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function service(){
        return $this->hasOne(HmsService::class);
    }
}
