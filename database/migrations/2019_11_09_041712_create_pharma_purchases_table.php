<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharma_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('invoice');
            $table->string('slug');
            $table->text('description')->nullable();

            $table->decimal('purchase_amount',8,2)->default(0);
            $table->decimal('tax_percent',8,2)->default(0);
            $table->decimal('grand_total',8,2)->default(0);
            $table->decimal('discount',6,2)->default(0);
            $table->decimal('payable_amount',8,2)->default(0);

            $table->integer('trans_id')->default(0);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('manufacturer_id')->default(1);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('manufacturer_id')->references('id')->on('pharma_manufacturers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pharma_purchases');
    }
}

