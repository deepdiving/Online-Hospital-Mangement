<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHmsOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hms_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice');
            $table->string('slug')->nullable();
            $table->date('date');
            $table->time('time');
            $table->unsignedBigInteger('operation_service_id');
            $table->string('operation_service_name');
            $table->integer('operation_service_price');
            $table->decimal('discount',8,2)->default(0);
            $table->decimal('grand_total',8,2)->default(0);
            $table->decimal('paid_amount',8,2)->default(0);
            $table->decimal('due',8,2)->default(0);
            $table->decimal('change',8,2)->default(0);
            $table->decimal('actual_amount',8,2)->default(0);
            $table->decimal('due_collection',8,2)->default(0);
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('trans_id')->default(0);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->unsignedBigInteger('admission_id')->default(1);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->timestamps();
            $table->foreign('operation_service_id')->references('id')->on('hms_operation_services')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admission_id')->references('id')->on('hms_admissions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hms_operations');
    }
}
