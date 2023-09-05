<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('intMenu_ID');
            $table->string('txtMenu', 64);
            $table->string('txtIcon', 64);
            $table->string('txtRoute', 64)->nullable();
            $table->string('txtUrl', 64)->nullable();
            $table->integer('intQueue');
            $table->timestamp('dtmCreatedAt')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('dtmUpdatedAt')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
