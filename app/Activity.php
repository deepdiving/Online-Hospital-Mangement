<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id','name','module','action','notes'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
