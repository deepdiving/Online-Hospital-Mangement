<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHmsServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hms_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->integer('price')->nullable();
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->unsignedBigInteger('service_category_id')->default(1);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->timestamps();
            $table->foreign('service_category_id')->references('id')->on('hms_service_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hms_services');
    }
}
