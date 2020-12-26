<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDueCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('due_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('slug');
            $table->string('invoice');
            $table->unsignedBigInteger('trans_id')->default(0);
            $table->decimal('amount',8,2)->default(0.00);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->enum('module', ['Pharmacy', 'Diagnostic','Hospital'])->default('Pharmacy');
            $table->enum('sub_module', ['Hospital-Admission', 'Hospital-Emergency','Hospital-Operation'])->nullable();
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('due_collections');
    }
}
