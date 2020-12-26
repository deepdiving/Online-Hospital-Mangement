<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pharma\Sale;
use App\Transation;
use App\Models\Diagnostic\Bill;
use App\Models\hospital\HmsAdmission;
use App\Models\hospital\HmsGivenService;
use App\DueCollection;
use App\DueCollectionItem;
use App\Models\hospital\HmsEmergency;
use App\Models\hospital\HmsOperation;
use App\Models\hospital\BedChargeCollection;
use App\Models\doctor\DocAppointment;
use App\Models\doctor\Prescription;
use App\Models\laboratory\LabReport;
use App\Models\Diagnostic\BillItem;


class Patient extends Model
{
    protected $fillable = ['patient_name', 'slug', 'email', 'phone','age', 'address','picture','password','gender','description','marital_status','blood_group','guardian','relationship','guardian_phone','occupation','religion','user_id', 'status'];
    protected $table = 'patients';
    public function getRouteKeyName(){
        return 'slug';
    }

    public function scopeActive($query){
        return $query->where('status', 'Active');
    }

    public function sales(){
        return $this->hasMany(Sale::class, 'patient_id');
    }
    public function transation(){
        return $this->hasMany(Transation::class, 'vendor_id');
    }
    public function bill(){
        return $this->hasMany(Bill::class,'patient_id');
    }
    public function admission(){
        return $this->hasOne(HmsAdmission::class,'patient_id');
    }
    public function service(){
        return $this->hasOne(HmsGivenService::class);
    }
    public function duecollection(){
        return $this->hasMany(DueCollection::class,'patient_id');
    }
    public function duecollectionitem(){
        return $this->hasMany(DueCollectionItem::class,'patient_id');
    }

    public function emergency(){
        return $this->hasOne(HmsEmergency::class,'patient_id');
    }
    public function operation(){
        return $this->hasOne(HmsOperation::class,'patient_id');
    }

    public function bedchargecollection(){
        return $this->hasOne(BedChargeCollection::class,'patient_id');
    }

    public function appointment(){
        return $this->hasOne(DocAppointment::class,'patient_id');
    }

    public function prescription(){
        return $this->hasMany(Prescription::class, 'patient_id');
    }
    public function laboratory(){
        return $this->hasMany(LabReport::class,'patient_id');
    }
    public function billitem(){
        return $this->hasMany(BillItem::class,'patient_id');
    } 



}