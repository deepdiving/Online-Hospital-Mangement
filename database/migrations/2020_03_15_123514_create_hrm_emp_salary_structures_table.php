<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmpSalaryStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_emp_salary_structures', function (Blueprint $table) {
            $table->bigIncrements('id');           
            $table->decimal('amount',8,2)->default(0); 
            $table->enum('status', ['Active','Void'])->default('Active');
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('salary_structure_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('emp_id')->references('id')->on('hrm_employees')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('salary_structure_id')->references('id')->on('hrm_salary_structures')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hrm_emp_salary_structures');
    }
}
