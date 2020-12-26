<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use App\Notification;
use App\Unit;
use App\Models\Diagnostic\Bill;
use App\Models\hospital\HmsAdmission;
use App\DueCollection;
use App\DueCollectionItem;
use App\Models\hospital\HmsEmergency;
use App\Models\hospital\Hmsoperation;
use App\Models\hospital\BedChargeCollection;
use App\Models\doctor\PreMedicine;
use App\Models\laboratory\LabReport;
use App\Models\hrm\SalaryTrack;
use App\Doctor;
use App\Transation;
use App\Expense;

class User extends EloquentUser
{
    protected $fillable = ['name', 'email', 'password', 'last_name', 'first_name', 'permissions', 'profile_image', 'profile_banar'];

    public function notification()
    {
        return $this->hasMany(Notification::class, 'user');
    }
    public function unit()
    {
        return $this->hasMany(Unit::class, 'user_id');
    }
    public function Tax()
    {
        return $this->hasMany(ProductTax::class, 'user_id');
    }
    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
    public function admission()
    {
        return $this->hasOne(HmsAdmission::class);
    }
    public function duecollection(){
        return $this->hasMany(DueCollection::class);
    }
    public function duecollectionitem(){
        return $this->hasMany(DueCollectionItem::class);
    }
    public function emergency(){
        return $this->hasOne(HmsEmergency::class);
    }
    public function operation(){
        return $this->hasOne(Hmsoperation::class);
    }
    public function bed_charge(){
        return $this->hasOne(BedChargeCollection::class);
    }
    public function doctor(){
        return $this->hasOne(Doctor::class);
    }
    public function transaction(){
        return $this->hasMany(Transation::class,'user_id');
    }
    public function expence(){
        return $this->hasMany(Expense::class,'user_id');
    }

    public function premedicine(){
        return $this->hasMany(PreMedicine::class,'user_id');
    }
    public function labreport(){
        return $this->hasMany(LabReport::class,'user_id');
    }
    public function slarytrack(){
        return $this->hasMany(SalaryTrack::class,'user_id');
    }
}
