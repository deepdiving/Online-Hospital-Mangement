<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaPurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharma_purchase_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->decimal('unit_price',8,2)->default(0);
            $table->decimal('total_price',8,2)->default(0);
            $table->integer('was_stock')->default(0);
            $table->integer('new_stock')->default(0);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('manufacturer_id')->references('id')->on('pharma_manufacturers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('purchase_id')->references('id')->on('pharma_purchases')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('pharma_products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharma_purchase_items');
    }
}

