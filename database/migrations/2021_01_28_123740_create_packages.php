<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('packages_id');
            $table->string('package_name',100);
            $table->integer('products_id')->unsigned();
            $table->foreign('products_id')
                ->references('products_id')->on('products');
            $table->decimal('package_price',12,2);
            $table->enum('package_type',['Regular','Customize']);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
