<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdEkskulOptToPendaftaranEkskulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_ekskul', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ekskul_opt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_ekskul', function (Blueprint $table) {
            $table->dropColumn('id_ekskul_opt');
        });
    }
}
