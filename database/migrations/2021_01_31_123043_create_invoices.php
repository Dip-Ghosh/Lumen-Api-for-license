<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('invoices_id');
            $table->string('inv_code',20)->unique();
            $table->integer('customers_id')->unsigned();
            $table->foreign('customers_id')
                ->references('customers_id')->on('customers');
            $table->decimal('inv_amount',12,2);
            $table->date('inv_date')->nullable();
            $table->date('due_date')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
