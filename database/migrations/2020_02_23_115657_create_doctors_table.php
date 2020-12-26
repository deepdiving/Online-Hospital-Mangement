<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('email');
            $table->unsignedBigInteger('department_id')->default(1);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('own_user_id')->default(0);
            $table->string('picture')->nullable();
            $table->enum('gender',['Male','Female'])->default('Male');
            $table->string('blood_group')->default('A+');
            $table->string('designation')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('address')->nullable();
            $table->text('biography')->nullable();
            $table->integer('age')->nullable();
            $table->enum('marital_status', ['Married', 'Single'])->default('Single');
            $table->enum('religion', ['Islam','Hindu','Buddha','Christian','Other'])->default('Islam');
            $table->enum('status', ['Active', 'Void'])->default('Active'); 
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
