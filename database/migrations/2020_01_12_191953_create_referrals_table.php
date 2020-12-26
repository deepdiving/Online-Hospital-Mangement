<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->string('name')->nullable();                  
            $table->decimal('price',5,2)->default(0);           
            $table->string('designation')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('referral_category_id')->default(1);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->timestamps();
            $table->foreign('referral_category_id')->references('id')->on('referral_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referrals');
    }
}
