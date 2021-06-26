<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->increments('licenses_id');
            $table->string('license_code',20)->unique();
            $table->integer('customers_id')->unsigned();
            $table->foreign('customers_id')
                ->references('customers_id')->on('customers');
            $table->integer('products_id')->unsigned();
            $table->foreign('products_id')
                ->references('products_id')->on('products');
            $table->string('license_key',100)->unique();
            $table->date('start_date')->nullable();
            $table->date('last_renewal_date')->nullable();
            $table->smallInteger('hold_count')->nullable();
            $table->smallInteger('license_period')->nullable();
            $table->smallInteger('after_expiry_allow_days')->nullable();
            $table->smallInteger('max_user')->nullable();
            $table->smallInteger('notify_expiry')->nullable();
            $table->integer('packages_id')->unsigned();
            $table->foreign('packages_id')
                ->references('packages_id')->on('packages');
            $table->decimal('license_price',12,2);
            $table->enum('license_status',['Active','Temporarily Blocked','Permanently Blocked','Removed'])->default('Active');
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
        Schema::dropIfExists('licenses');
    }
}
