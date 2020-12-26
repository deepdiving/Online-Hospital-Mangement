<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharma_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('generic_name')->nullable();
            $table->text('note')->nullable();
            $table->integer('box_size')->default(0);
            $table->string('image')->nullable();
            $table->decimal('tax',8,2)->default(0)->nullable();
            $table->decimal('purchase_price',8,2)->default(0);
            $table->decimal('sale_price',8,2)->default(0);
            $table->integer('stock')->default(0);
            $table->string('shelf_no')->default(0)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->unsignedBigInteger('product_type_id');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->foreign('product_type_id')->references('id')->on('pharma_product_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('unit_id')->references('id')->on('pharma_units')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('pharma_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('manufacturer_id')->references('id')->on('pharma_manufacturers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharma_products');
    }
}