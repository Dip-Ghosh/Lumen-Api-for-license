<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('products_id');
            $table->string('product_code',20)->unique();
            $table->string('product_name',100)->unique();
            $table->text('product_descriptions')->nullable();
            $table->string('server_ip',50)->nullable();
            $table->string('base_url',100)->nullable();
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
        Schema::dropIfExists('products');
    }
}
