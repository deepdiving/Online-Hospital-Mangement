<?php

namespace App\Models\hospital;

use Illuminate\Database\Eloquent\Model;
use App\Models\hospital\HmsOperationType;
class HmsOperationService extends Model
{
    protected $fillable =['name','slug','price','status','operation_type_id','user_id'];
        
 public function category(){
    return $this->belongsTo(HmsOperationType::class,'operation_type_id');
 }

}
