<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharma_batches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('purchase_id')->default(0);
            $table->unsignedBigInteger('purchase_item_id')->default(0);
            $table->string('batch_number');
            $table->integer('in_stock');
            $table->date('expiry_date');
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            // $table->foreign('purchase_item_id')->references('id')->on('purchase_items')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('pharma_products')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharma_batches');
    }
}
