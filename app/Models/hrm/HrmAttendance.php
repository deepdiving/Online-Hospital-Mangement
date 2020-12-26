<?php

namespace App\models\hrm;

use Illuminate\Database\Eloquent\Model;
use App\Models\hrm\HrmEmployee;
class HrmAttendance extends Model
{
    protected $fillable = ['emp_id','date','time','status','user_id'];

    public function employee(){
        return $this->belongsTo(HrmEmployee::class,'emp_id');
    }
}
