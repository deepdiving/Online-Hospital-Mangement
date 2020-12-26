<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharma_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('invoice');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('sub_total',8,2)->default(0);
            $table->decimal('invoice_discount',8,2)->default(0);
            $table->decimal('total_discount',8,2)->default(0);
            $table->decimal('tax_percent',8,2)->default(0);
            $table->decimal('total_tax',8,2)->default(0);
            $table->decimal('grand_total',8,2)->default(0);
            // $table->decimal('pre_balance',8,2)->default(0);
            // $table->decimal('net_total',8,2)->default(0);
            $table->decimal('paid_amount',8,2)->default(0);
            $table->decimal('new_balance',8,2)->default(0);
            $table->decimal('due_collection',8,2)->default(0);
            $table->decimal('change',8,2)->default(0);
            $table->unsignedBigInteger('trans_id')->default(0);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('patient_id')->default(1);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pharma_sales');
    }
}
