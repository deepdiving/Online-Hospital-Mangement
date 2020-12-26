<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('expense_category_id');
            $table->decimal('amount',8,2)->default(0.00);
            $table->text('description');
            $table->enum('payment_type', ['bank', 'cash']);
            $table->integer('bank_transaction_id')->default(0);
            $table->enum('status', ['Active', 'Void'])->default('Active');
            $table->enum('module', ['Pharmacy', 'Diagnostic','Hospital'])->default('Pharmacy');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('expense_category_id')->references('id')->on('expense_categories')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
