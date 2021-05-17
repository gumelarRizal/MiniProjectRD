<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationships2ToPendaftaranEkskulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_ekskul', function (Blueprint $table) {
            $table->foreign('id_ekskul_opt')
                ->references('id')->on('ekskul')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
            $table->dropForeign('pendaftaran_ekskul_id_ekskul_opt_foreign');
        });
    }
}
