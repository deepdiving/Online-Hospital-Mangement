<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cat_name');
            $table->decimal('price',5,2)->default(0);    
            $table->string('slug')->nullable();
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->timestamps();
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
        Schema::dropIfExists('referral_categories');
    }
}
