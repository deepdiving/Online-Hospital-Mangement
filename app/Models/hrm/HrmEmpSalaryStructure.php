<?php

namespace App\models\hrm;

use Illuminate\Database\Eloquent\Model;
use App\Models\hrm\HrmEmployee;
use App\Models\hrm\HrmSalaryStructure;
class HrmEmpSalaryStructure extends Model
{
    protected $fillable = ['emp_id','salary_structure_id','amount','status','user_id'];

    public function employee(){
        return $this->belongsTo(HrmEmployee::class,'emp_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function salarystr(){
        return $this->belongsTo(HrmSalaryStructure::class,'salary_structure_id');
    }
    
}
