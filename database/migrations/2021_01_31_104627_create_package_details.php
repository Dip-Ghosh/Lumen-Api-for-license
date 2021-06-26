<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_details', function (Blueprint $table) {
            $table->increments('package_details_id');
            $table->integer('products_id')->unsigned();
            $table->foreign('products_id')
                ->references('products_id')->on('products');
            $table->integer('packages_id')->unsigned();
            $table->foreign('packages_id')
                ->references('packages_id')->on('packages');
            $table->integer('product_module_features_id')->unsigned()->nullable();
            $table->foreign('product_module_features_id')
                ->references('product_module_features_id')->on('product_module_features');
            $table->integer('product_modules_id')->unsigned();
            $table->foreign('product_modules_id')
                ->references('product_modules_id')->on('product_modules');
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
        Schema::dropIfExists('package_details');
    }
}
