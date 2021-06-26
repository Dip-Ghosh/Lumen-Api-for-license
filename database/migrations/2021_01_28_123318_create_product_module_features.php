<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductModuleFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_module_features', function (Blueprint $table) {
            $table->increments('product_module_features_id');
            $table->integer('products_id')->unsigned();
            $table->foreign('products_id')
                ->references('products_id')->on('products');
            $table->integer('product_modules_id')->unsigned();
            $table->foreign('product_modules_id')
                ->references('product_modules_id')->on('product_modules');
            $table->string('features_code',10)->nullable()->comment('feature/menu id of application database');
            $table->string('features_name',100);
            $table->text('feature_details')->nullable();
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
        Schema::dropIfExists('product_module_features');
    }
}
