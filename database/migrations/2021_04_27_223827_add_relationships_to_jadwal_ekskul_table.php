<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToJadwalEkskulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jadwal_ekskul', function (Blueprint $table) {
            $table->foreign('id_ekskul')
                ->references('id')->on('ekskul')
                ->onUpdate('cascade')
                ->onDelete('cascade'); 

            $table->foreign('id_pelatih')
                ->references('id')->on('pelatih')
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
        Schema::table('jadwal_ekskul', function (Blueprint $table) {
            $table->dropForeign('jadwal_ekskul_id_ekskul_foreign');
            $table->dropForeign('jadwal_ekskul_id_pelatih_foreign');
        });
    }
}
