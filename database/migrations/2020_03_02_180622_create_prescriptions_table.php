<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice');
            $table->date('date');
            $table->text('symptoms')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('advices')->nullable();
            $table->date('next_appointment');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id')->default(0);
            $table->unsignedBigInteger('doctor_id');
            $table->enum('status', ['Active', 'Void' , 'Draft'])->default('Active');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('appointment_id')->references('id')->on('doc_appointments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('prescriptions');
    }
}
