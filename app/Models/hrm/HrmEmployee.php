<?php

namespace App\models\hrm;

use Illuminate\Database\Eloquent\Model;
use App\Models\hrm\HrmDepartment;
use App\Models\hrm\HrmPosition;
use App\Models\hrm\HrmAttendance;
use App\Models\hrm\HrmEmpSalaryStructure;
use App\Models\hrm\HrmEmpPaidSalaryStructure;
class HrmEmployee extends Model
{
    protected $fillable = ['name','email','address','phone_no','basic_salary','gross_salary','date_of_birth','joining_date','gender','marital_status','picture','emergency_contact','emergency_address','department_id','position_id','status','user_id'];

    public function department(){
        return $this->belongsTo(HrmDepartment::class,'department_id');
    }

    public function position(){
        return $this->belongsTo(HrmPosition::class,'position_id');
    }

    public function attendance(){
        return $this->hasMany(HrmAttendance::class,'emp_id');
    }

     public function empPaidSalary(){
        return $this->hasMany(HrmEmpPaidSalaryStructure::class,'emp_id');
     }

     public function empSalaryStr(){
        return $this->hasMany(HrmEmpSalaryStructure::class,'emp_id');
     }
}
