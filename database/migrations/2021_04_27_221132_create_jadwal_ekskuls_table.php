<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalEkskulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_ekskul', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ekskul');
            $table->string('hari');
            // $table->time('jam');
            $table->string('tempat');
            $table->unsignedBigInteger('id_pelatih');
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
        Schema::dropIfExists('jadwal_ekskul');
    }
}
