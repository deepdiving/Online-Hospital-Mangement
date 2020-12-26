<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreMedicineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_medicine_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('medicine');
            $table->string('dose');
            $table->integer('days');
            $table->string('use_time');
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->unsignedBigInteger('pre_medicine_id');  
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pre_medicine_id')->references('id')->on('pre_medicines')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pre_medicine_items');
    }
}
