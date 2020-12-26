<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_reports', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->date('date');
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('diagon_bill_id');
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('patient_id')->default(1); 
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['Active','Void'])->default('Active');
            $table->timestamps();
            $table->foreign('diagon_bill_id')->references('id')->on('diagon_bills')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade'); 
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
        Schema::dropIfExists('lab_reports');
    }
}
