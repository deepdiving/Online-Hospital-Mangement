<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagonBillItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagon_bill_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('bill_id')->default(1);
            $table->unsignedBigInteger('test_id')->default(1);
            $table->decimal('test_price',8,2)->default(0);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->timestamps();
            $table->foreign('test_id')->references('id')->on('diagon_test_lists')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bill_id')->references('id')->on('diagon_bills')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('diagon_bill_items');
    }
}
