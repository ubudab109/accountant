<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_rekap');
            $table->string('id_pgw')->index();
            $table->foreign('id_pgw')->references('id_pegawai')->on('pegawai')->onDelete('cascade');
            $table->integer('hadir')->nullable();
            $table->integer('sakit')->nullable();
            $table->integer('cuti')->nullable();
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
        Schema::dropIfExists('table_absensi');
    }
}
