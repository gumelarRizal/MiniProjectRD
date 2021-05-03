<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 8)->unique();
            $table->string('nama', 50);
            $table->string('kelas', 8);
            $table->string('alamat', 200);
            $table->string('tempat_lahir', 20);
            $table->char('jenis_kelamin', 1);
            $table->date('tanggal_lahir');
            $table->string('no_telp', 12);
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('siswa');
    }
}
