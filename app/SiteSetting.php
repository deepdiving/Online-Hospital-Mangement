<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['site_name','address','phone_number','website','email','footer_text','language','timezone','currency','currency_symbol','cur_position','date_format','sale_prefix','purchase_prefix','transaction_prefix','bank_transaction_prefix','sale_return_prefix','purchase_return_prefix','batch_prefix','sale_tax','purchase_tax','mini_sidebar','theme','voucher_type','prefix_diagnostic_bill','prefix_asset'];
}
