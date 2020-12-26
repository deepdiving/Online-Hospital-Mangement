<?php

namespace App\models\hrm;

use Illuminate\Database\Eloquent\Model;
use App\Models\hrm\HrmEmployee;
use App\Models\hrm\HrmEmpPaidSalaryStructure;
class HrmSalary extends Model
{
    protected $fillable = ['salary_track_id','emp_id','date','year','month','paid_by','basic_salary','gross_salary','addamount','deductamount','thismonthamount','status','user_id'];

    public function employee(){
        return $this->belongsTo(HrmEmployee::class,'emp_id');
    }
    public function empPaidSalaryStr(){
        return $this->hasMany(HrmEmpPaidSalaryStructure::class,'hrm_salary_id');
    }
    
}
