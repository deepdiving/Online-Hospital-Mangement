<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmpPaidSalaryStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_emp_paid_salary_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('hrm_salary_id');


            $table->string('structure');
            $table->decimal('percent',8,2)->default(0);
            $table->decimal('amount',8,2)->default(0);
            $table->enum('type', ['Add','Deduct'])->default('Add');
            

            $table->enum('status', ['Active','Void'])->default('Active');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->foreign('emp_id')->references('id')->on('hrm_employees')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hrm_salary_id')->references('id')->on('hrm_salaries')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('hrm_emp_paid_salary_structures');
    }
}
