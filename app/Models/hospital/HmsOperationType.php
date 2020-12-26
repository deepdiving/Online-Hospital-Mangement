<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Models\hospital\HmsOperationService;
class HmsOperationType extends Model
{
    protected $fillable =['name','slug','status','user_id'];
    
    public function type(){
         return $this->hasMany(HmsOperationService::class,'operation_type_id');
    }
}