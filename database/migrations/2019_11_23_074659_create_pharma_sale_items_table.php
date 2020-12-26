<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharma_sale_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('batch_id');
            $table->integer('current_stock');
            $table->date('expiry_date');
            $table->integer('sale_qty');
            $table->decimal('unit_price',8,2)->default(0);
            $table->decimal('discount_percent',8,2)->default(0);
            $table->decimal('discount_amount',8,2)->default(0);
            $table->decimal('total_price',8,2)->default(0);
            $table->integer('new_stock')->default(0);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('batch_id')->references('id')->on('pharma_batches')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sale_id')->references('id')->on('pharma_sales')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pharma_sale_items');
    }
}
