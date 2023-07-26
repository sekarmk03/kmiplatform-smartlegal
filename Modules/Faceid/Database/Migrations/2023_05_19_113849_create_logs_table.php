<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('faceid')->create('logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->foreignId('device_id')->constrained('devices');
            $table->integer('moustache')->default(0);
            $table->integer('beard')->default(0);
            $table->string('foto')->nullable();
            $table->integer('suhu');
            $table->timestamp('waktu');
            $table->enum('status', ["Healthy", "Not Healthy"])->nullable();
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
        Schema::connection('faceid')->dropIfExists('logs');
    }
}
