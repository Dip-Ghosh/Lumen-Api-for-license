<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payments_id');
            $table->integer('invoices_id')->unsigned();
            $table->foreign('invoices_id')
                ->references('invoices_id')->on('invoices');
            $table->decimal('paid_amount',12,2);
            $table->date('payment_date');
            $table->enum('payment_method',['Credit Card','Bank Deposit','PayPal','Mobile Banking']);
            $table->date('payment_settlement_date')->nullable();
            $table->apsisColumn();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
