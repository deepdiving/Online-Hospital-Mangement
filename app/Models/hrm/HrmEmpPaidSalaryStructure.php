<?php

namespace App\models\hrm;

use Illuminate\Database\Eloquent\Model;
use App\Models\hrm\HrmEmployee;
use App\Models\hrm\HrmEmpSalaryStructure;
use App\Models\hrm\HrmSalary;
class HrmEmpPaidSalaryStructure extends Model
{
    protected $fillable = ['emp_id','hrm_salary_id','structure','percent','amount','type','status','user_id'];

    public function employee(){
        return $this->belongsTo(HrmEmployee::class,'emp_id');
    }

    public function empsalarystr(){
        return $this->belongsTo(HrmEmpSalaryStructure::class,'emp_salary_structure_id');
    }

    public function salary(){
        return $this->belongsTo(HrmSalary::class,'hrm_salary_id');
    }
}
