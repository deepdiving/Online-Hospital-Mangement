<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Notification extends Model
{
    protected $fillable = ['user','content','is_read','url','from'];

    public function user(){
        return $this->belongsTo(User::class,'user');
    }
}
