<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_modules', function (Blueprint $table) {
            $table->increments('product_modules_id');
            $table->integer('products_id')->unsigned();
            $table->foreign('products_id')
                ->references('products_id')->on('products');
            $table->string('module_code',20)->comment('module of of application database');
            $table->string('module_name',50);
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
        Schema::dropIfExists('product_modules');
    }
}
