<?php

namespace App;
use App\ExpenseCategory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Expense extends Model
{
    protected $fillable = [ 'date','expense_category_id','amount','payment_type','description','module','bank_transaction_id','user_id'];

    public function category(){
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
    