<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_no')->nullable();
            $table->integer('basic_salary');
            $table->integer('gross_salary');
            $table->date('date_of_birth');           
            $table->date('joining_date');
            $table->string('address')->nullable();
            $table->enum('gender', ['Male', 'Female','Other'])->default('Female');
            $table->enum('marital_status', ['Married', 'Single'])->default('Single');
            $table->string('picture')->nullable();           
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_address')->nullable();
            $table->enum('status', ['Active','Void'])->default('Active');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('hrm_departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('position_id')->references('id')->on('hrm_positions')->onDelete('cascade')->onUpdate('cascade'); 
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
        Schema::dropIfExists('hrm_employees');
    }
}
