<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mmenus', function (Blueprint $table) {
            $table->increments('intMenu_ID');
            $table->string('txtMenuTitle', 64);
            $table->string('txtMenuIcon', 64);
            $table->string('txtCreatedBy', 128)->nullable();
            $table->timestamp('dtmCreated')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('txtUpdatedBy', 128)->nullable();
            $table->timestamp('dtmUpdated')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mmenus');
    }
}
