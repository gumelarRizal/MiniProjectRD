<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToPendaftaranEkskulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_ekskul', function (Blueprint $table) {
            $table->foreign('id_ekskul')
                ->references('id')->on('ekskul')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_siswa')
                ->references('id')->on('siswa')
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
            $table->dropForeign('pendaftaran_ekskul_id_ekskul_foreign');
            $table->dropForeign('pendaftaran_ekskul_id_pembina_foreign');
            $table->dropForeign('pendaftaran_ekskul_id_siswa_foreign');
        });
    }
}
