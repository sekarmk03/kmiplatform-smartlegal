<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('faceid')->create('foto_karyawans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('foto')->nullable();
            $table->integer('is_export')->default(0);
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
        Schema::connection('faceid')->dropIfExists('foto_karyawans');
    }
}
