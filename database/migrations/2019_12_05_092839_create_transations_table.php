<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('trans_id');
            $table->decimal('amount',8,2)->default(0.00);
            $table->text('description')->nullable();
            $table->enum('transaction_way', ['Bank', 'Cash'])->default('Cash');
            $table->integer('bank_transaction_id')->default(0);
            $table->integer('vendor_id');
            $table->enum('vendor', ['Patient', 'Manufacturer', 'Expense' ,'Referral','Doctor'])->default('Patient');
            $table->enum('transaction_type', ['Payment', 'Received','Collection'])->default('Received');
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->enum('module', ['Pharmacy', 'Diagnostic','Hospital','Receptionist'])->default('Pharmacy');
            $table->enum('sub_module', ['Hospital-Admission', 'Hospital-Emergency','Hospital-Operation','Hospital-BedChargeCollection','Diagnostic-Appointment'])->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('transations');
    }
}
