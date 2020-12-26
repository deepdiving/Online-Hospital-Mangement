<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('paid_by');
            $table->integer('basic_salary');
            $table->integer('gross_salary');
            $table->integer('addamount')->nullable();
            $table->integer('deductamount')->nullable();
            $table->integer('thismonthamount')->nullable();
            $table->enum('status', ['Pending', 'Paid'])->default('Pending');
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('salary_track_id');
            $table->timestamps();
            $table->foreign('emp_id')->references('id')->on('hrm_employees')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('salary_track_id')->references('id')->on('salary_tracks')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hrm_salaries');
    }
}
