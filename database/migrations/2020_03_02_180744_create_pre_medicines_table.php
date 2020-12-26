<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('count')->nullable();
            $table->unsignedBigInteger('pre_medicine_type_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('pre_medicine_type_id')->references('id')->on('pre_medicine_types')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pre_medicines');
    }
}
