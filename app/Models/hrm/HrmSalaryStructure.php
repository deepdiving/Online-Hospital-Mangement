<?php

namespace App\models\hrm;

use Illuminate\Database\Eloquent\Model;
use App\Models\hrm\HrmEmpSalaryStructure;
class HrmSalaryStructure extends Model
{
    protected $fillable = ['title','type','amount','status','user_id'];

    public function empsalarystr(){
        return $this->hasMany(HrmEmpSalaryStructure::class,'salary_structure_id');
     }
}
