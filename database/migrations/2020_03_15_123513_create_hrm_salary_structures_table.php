<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmSalaryStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_salary_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->decimal('amount',8,2)->default(0.00);
            $table->enum('type', ['Add','Deduct'])->default('Add');
            $table->enum('status', ['Active','Void'])->default('Active');
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('hrm_salary_structures');
    }
}
