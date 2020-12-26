<?php

namespace App\Models\hrm;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SalaryTrack extends Model
{
    protected $fillable = ['date','month','year','status','user_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
