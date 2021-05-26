<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNilaiColumnToPendaftaranEkskulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_ekskul', function (Blueprint $table) {
            $table->string('nilai')->change();
            $table->string('nilai_opt')->change();
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
            $table->double('nilai')->nullable();
            $table->double('nilai_opt')->nullable();
        });
    }
}
