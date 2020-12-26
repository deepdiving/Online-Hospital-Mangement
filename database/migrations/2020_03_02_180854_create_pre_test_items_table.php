<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreTestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_test_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('test');
            $table->unsignedBigInteger('diagon_test_id');
            $table->unsignedBigInteger('prescription_id');
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('diagon_test_id')->references('id')->on('diagon_test_lists')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pre_test_items');
    }
}
