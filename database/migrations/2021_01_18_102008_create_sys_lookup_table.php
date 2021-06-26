<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLookupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_lookups', function (Blueprint $table) {
            $table->increments('sys_lookups_id');
            $table->integer('modules_id');
            $table->string('lookup_group',100);
            $table->string('lookup_option',100);
            $table->string('lookup_value',100);
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
        Schema::dropIfExists('sys_lookup');
    }
}
