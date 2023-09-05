<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('intLevel_ID');
            $table->unsignedInteger('intDepartment_ID');
            $table->string('txtName', 128);
            $table->string('txtNik', 16);
            $table->string('txtUsername', 64);
            $table->string('txtInitial', 6);
            $table->string('txtEmail', 64);
            $table->string('txtPhoto', 64);
            $table->string('txtPassword', 155);
            $table->string('txtCreatedBy', 128)->nullable();
            $table->timestamp('dtmCreated')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('txtUpdatedBy', 128)->nullable();
            $table->timestamp('dtmUpdated')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            //Foreign Key to : Level ID
            $table->foreign('intLevel_ID')
                ->references('intLevel_ID')
                ->on('mlevels')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            //Foreign Key to : Department ID
            $table->foreign('intDepartment_ID')
                ->references('intDepartment_ID')
                ->on('mdepartments')
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
        Schema::dropIfExists('musers');
    }
}
