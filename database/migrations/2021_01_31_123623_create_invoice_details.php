<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->increments('invoice_details_id');
            $table->integer('invoices_id')->unsigned();
            $table->foreign('invoices_id')
                ->references('invoices_id')->on('invoices');
            $table->string('line_item')->nullable();
            $table->decimal('qty',10,2);
            $table->decimal('rate',10,2);
            $table->decimal('total_amount',12,2);
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
        Schema::dropIfExists('invoice_details');
    }
}
