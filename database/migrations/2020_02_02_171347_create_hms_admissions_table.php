<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHmsAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hms_admissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->date('date');
            $table->string('invoice');
            $table->date('admit_date');
            $table->time('admit_time');

            $table->decimal('sub_total',8,2)->default(0);
            $table->decimal('discount_percent',5,2)->default(0);
            $table->decimal('discount_overall',8,2)->default(0);
            $table->decimal('discount_total',8,2)->default(0);

            $table->decimal('grand_total',8,2)->default(0);
            $table->decimal('paid_amount',8,2)->default(0);
            $table->decimal('actual_paid_amount',8,2)->default(0);
            $table->decimal('due',8,2)->default(0);
            $table->decimal('due_collection',8,2)->default(0);
            $table->decimal('change',8,2)->default(0);

            $table->date('discharge_date')->nullable();
            $table->time('discharge_time')->nullable();
            
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('bed_id')->nullable();
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('trans_id')->default(0);
            $table->unsignedBigInteger('referral_id')->default(1); 

            // $table->enum('is_discharge', ['Yes', 'No'])->default('No');

            $table->enum('status', ['Active', 'Void','Discharged'])->default('Active');
            $table->timestamps();
            $table->foreign('referral_id')->references('id')->on('referrals')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bed_id')->references('id')->on('hms_beds')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hms_admissions');
    }
}
