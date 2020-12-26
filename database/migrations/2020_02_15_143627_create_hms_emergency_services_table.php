<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHmsEmergencyServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hms_emergency_services', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('hms_emergency_id')->default(1);
            $table->date('service_date');
            $table->integer('service_id')->default(0);
            $table->string('service_name')->default('');
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->decimal('service_price')->default(0);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('hms_emergency_id')->references('id')->on('hms_emergencies')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hms_emergency_services');
    }
}
