<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsEditToFotoKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('faceid')->table('foto_karyawans', function (Blueprint $table) {
            $table->integer('is_edit')->after('is_export')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('faceid')->table('foto_karyawans', function (Blueprint $table) {
            $table->dropColumn('is_edit');
        });
    }
}
