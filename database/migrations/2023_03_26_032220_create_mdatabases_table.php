<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMdatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdatabases', function (Blueprint $table) {
            $table->increments('intDatabase_ID');
            $table->unsignedInteger('intAccount_ID');
            $table->string('txtDatabaseName', 64);
            $table->string('txtCreatedBy', 128)->nullable();
            $table->timestamp('dtmCreated')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('txtUpdatedBy', 128)->nullable();
            $table->timestamp('dtmUpdated')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            //Foreign Key to : User ID
            $table->foreign('intAccount_ID')
                ->references('intAccount_ID')
                ->on('maccounts')
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
        Schema::dropIfExists('mdatabases');
    }
}
