<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\diagnostic\DiagonReferral;
class ReferralCategory extends Model
{
    protected $fillable = ['cat_name','price','user_id','slug','status'];

    public function getRouteKeyName(){
         return 'slug';
    }

    public function referral(){
        return $this->hasMany(DiagonReferral::class, 'referral_category_id');
    }
    
}  