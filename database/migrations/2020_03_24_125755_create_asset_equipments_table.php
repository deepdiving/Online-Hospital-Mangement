<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_equipment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_name');
            $table->text('description');
            $table->string('model');
            $table->string('identification_no');
            $table->string('serial_number');
            $table->enum('current_status', ['Usable', 'Not Usable','Repairable'])->default('Usable');
            $table->enum('condition', ['Good', 'Average','Damage'])->default('Good');
            $table->date('received_date');
            $table->decimal('acquisition_cost',8,2)->default(0);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('asset_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('location_id')->references('id')->on('asset_locations')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('asset_equipments');
    }
}
