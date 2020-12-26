<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->decimal('doctor_fees',8,2);
            $table->enum('week_day',['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('visit_qty')->default(20);
            $table->unsignedBigInteger('doctor_id')->default(1);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('doc_schedules');
    }
}
