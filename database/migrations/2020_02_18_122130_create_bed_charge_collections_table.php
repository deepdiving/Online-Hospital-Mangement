<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedChargeCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed_charge_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->date('date');
            $table->string('invoice');
            // $table->time('time');

            $table->decimal('sub_total',8,2)->default(0);
            $table->decimal('discount',8,2)->default(0);

            $table->decimal('grand_total',8,2)->default(0);
            $table->decimal('paid_amount',8,2)->default(0);
            // $table->decimal('actual_paid_amount',8,2)->default(0);
            $table->decimal('due',8,2)->default(0);
            // $table->decimal('due_collection',8,2)->default(0);
            $table->decimal('advance',8,2)->default(0);
            $table->text('remark')->nullable();
            
            $table->unsignedBigInteger('bed_id')->default(1);
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->unsignedBigInteger('admission_id')->default(1);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('trans_id')->default(0);

            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('admission_id')->references('id')->on('hms_admissions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bed_id')->references('id')->on('hms_beds')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bed_charge_collections');
    }
}
