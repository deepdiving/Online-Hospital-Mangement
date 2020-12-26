<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('invoice');
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->unsignedBigInteger('doctor_id')->default(1);
            $table->unsignedBigInteger('doc_schedule_id')->default(1);
            $table->unsignedBigInteger('referral_id')->default(0);
            $table->unsignedBigInteger('trans_id')->default(0);
            $table->decimal('doctor_fees',8,2);
            $table->decimal('discount',8,2)->nullable();
            $table->decimal('net_fees',8,2);
            $table->integer('serial')->default(0);
            $table->text('remark')->nullable();
            $table->enum('status', ['Requested','Confirmed','Paid','Closed','Void'])->default('Confirmed');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('doc_schedule_id')->references('id')->on('doc_schedules')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('doc_appointments');
    }
}
