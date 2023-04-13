<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMmodulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mmodules', function (Blueprint $table) {
            $table->increments('intModule_ID');
            $table->unsignedBigInteger('user_id');
            $table->string('txtModuleName', 64);
            $table->boolean('intStatus')->default(1);
            $table->string('txtCreatedBy', 128)->nullable();
            $table->timestamp('dtmCreated')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('txtUpdatedBy', 128)->nullable();
            $table->timestamp('dtmUpdated')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            //Foreign Key to : User ID
            $table->foreign('user_id')
                ->references('id')
                ->on('musers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mmodules');
    }
}
