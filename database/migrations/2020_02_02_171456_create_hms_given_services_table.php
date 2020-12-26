<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHmsGivenServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hms_given_services', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('admission_id')->default(1);
            $table->integer('service_id')->default(0);
            $table->string('service_name')->default('');
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->decimal('service_price')->default(0);
            $table->date('service_date');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('admission_id')->references('id')->on('hms_admissions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hms_given_services');
    }
}
