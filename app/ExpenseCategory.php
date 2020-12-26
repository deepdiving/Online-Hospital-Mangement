<?php

namespace App;
use App\Expense;
use App\Transation;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = [ 'category_name','slug','user_id','status'];
   
    public function getRouteKeyName(){
        return 'slug';
    }
    
    public function expense(){
        return $this->hasMany(Expense::class,'expense_category_id');
    }
    public function transation(){
        return $this->hasMany(Transation::class, 'vendor_id');
    }
}
