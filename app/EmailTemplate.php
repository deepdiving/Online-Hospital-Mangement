<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name','slug','subject','content','description','from_name','from_email','cc_email'];

    public function getRouteKeyName(){
        return 'slug';
    }
}