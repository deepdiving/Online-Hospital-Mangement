<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaProductTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharma_product_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tax_name');
            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
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
        Schema::dropIfExists('pharma_product_taxes');
    }
}
