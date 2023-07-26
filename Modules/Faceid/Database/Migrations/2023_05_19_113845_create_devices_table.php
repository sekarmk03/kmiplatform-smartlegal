<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('faceid')->create('devices', function (Blueprint $table) {
            $table->id();
            $table->integer('iddev')->unique();
            $table->string('ipaddress')->unique();
            $table->string('nama_device');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('faceid')->dropIfExists('devices');
    }
}
