<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHmsBedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hms_beds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->decimal('price',8,2)->default(0);
            $table->string('bed_no')->default(0);
            $table->integer('patient')->default(0);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->unsignedBigInteger('bed_type_id')->default(1);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->timestamps();
            $table->foreign('bed_type_id')->references('id')->on('hms_bed_types')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hms_beds');
    }
}
