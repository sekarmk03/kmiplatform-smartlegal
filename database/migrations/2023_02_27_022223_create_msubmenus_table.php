<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMsubmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msubmenus', function (Blueprint $table) {
            $table->increments('intSubmenu_ID');
            $table->unsignedInteger('intMenu_ID');
            $table->string('txtSubmenuTitle', 64);
            $table->string('txtSubmenuIcon', 64);
            $table->string('txtUrl', 64);
            $table->string('txtRouteName', 64);
            $table->string('txtCreatedBy', 128)->nullable();
            $table->timestamp('dtmCreated')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('txtUpdatedBy', 128)->nullable();
            $table->timestamp('dtmUpdated')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            //Foreign Key to : Menu ID
            $table->foreign('intMenu_ID')
                ->references('intMenu_ID')
                ->on('mmenus')
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
        Schema::dropIfExists('msubmenus');
    }
}
