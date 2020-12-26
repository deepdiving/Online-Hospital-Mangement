<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagonReferralPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagon_referral_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('referral_id');
            $table->integer('trans_id')->default(0);
            $table->decimal('amount',8,2)->default(0);
            $table->text('description')->nullable();
            $table->string('module')->nullable();
            $table->unsignedBigInteger('user_id')->default(1);
            $table->timestamps();
            $table->foreign('referral_id')->references('id')->on('referrals')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('diagon_referral_payments');
    }
}
