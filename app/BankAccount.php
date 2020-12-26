<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class BankAccount extends Model
{
    protected $fillable = ['bank_name', 'account_number', 'account_name', 'branch_name', 'balance'];
}
