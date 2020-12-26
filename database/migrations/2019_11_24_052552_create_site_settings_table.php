<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('site_name');
            $table->String('address')->nullable();
            $table->String('phone_number')->nullable();
            $table->String('website')->nullable();
            $table->String('email')->nullable();
            $table->String('logo')->nullable();
            $table->String('login_banar')->nullable();
            $table->String('reg_banar')->nullable();
            $table->String('footer_text');
            
            $table->String('language')->default('en');
            $table->String('timezone')->default('Asia/Dhaka');
            $table->String('currency')->default('2');
            $table->String('currency_symbol')->default('$')->collation('utf8_unicode_ci');
            $table->String('cur_position')->default('before');
            $table->String('date_format')->default('M d, Y');
            $table->String('sale_prefix')->default('SALE');
            $table->String('purchase_prefix')->default('PUR');
            $table->String('transaction_prefix')->default('TRNS');
            $table->String('bank_transaction_prefix')->default('BT');
            $table->String('sale_return_prefix')->default('SR');
            $table->String('purchase_return_prefix')->default('PR');
            $table->String('batch_prefix')->default('BATCH');
            $table->float('sale_tax')->default('0.00');
            $table->float('purchase_tax')->default('0.00');
            $table->enum('voucher_type', ['A4', 'POS'])->default('A4');
            $table->String('prefix_diagnostic_bill')->default('DIA');
            $table->String('prefix_hms_admission')->default('HMS');
            $table->String('prefix_asset')->default('hms/assets/');
            //ui
            $table->string('mini_sidebar')->nullable();
            $table->string('theme')->default('red-dark');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}
