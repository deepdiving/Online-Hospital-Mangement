<?php

namespace App\models\hrm;

use Illuminate\Database\Eloquent\Model;
use App\Models\hrm\HrmEmployee;
class HrmDepartment extends Model
{
    protected $fillable = ['name','description','status','user_id'];

    public function employee(){
        return $this->hasMany(HrmEmployee::class,'emp_id');
     }
}
