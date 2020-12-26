<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patient_name');
            $table->string('slug');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullabel();
            $table->integer('age')->nullable();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('picture')->nullable();
            $table->string('attachment')->nullable();
            $table->string('password')->nullable();
            $table->enum('gender', ['Male', 'Female','Other'])->default('Female');
            $table->enum('marital_status', ['Married', 'Single'])->default('Single');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->enum('blood_group', ['A+','A-','B+','B-','O+','O-','AB+','AB-'])->default('A+');
            $table->string('guardian')->nullable();
            $table->string('relationship')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->enum('occupation',['Business','Professional','Student','House Wife','Labourers','Other'])->default('Business');
            $table->enum('religion', ['Islam','Hindu','Buddha','Christian','Other'])->default('Islam');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('patients');
    }
}
