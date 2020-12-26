<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedChargeCollectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed_charge_collection_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('collection_date');
            $table->decimal('amount',8,2)->default(0);
            $table->unsignedBigInteger('bed_charge_collection_id')->default(1);
            $table->timestamps();
            $table->foreign('bed_charge_collection_id')->references('id')->on('bed_charge_collections')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bed_charge_collection_items');
    }
}
