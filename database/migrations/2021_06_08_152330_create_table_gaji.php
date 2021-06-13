<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGaji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gaji')->unique()->index();
            $table->date('tanggal');
            $table->string('kode_pegawai')->index();
            $table->foreign('kode_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('cascade');
            $table->double('gaji_pokok');
            $table->double('potongan')->default(0);
            $table->double('bonus')->default(0);
            $table->double('total_gaji')->default(0);

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
        Schema::dropIfExists('table_gaji');
    }
}
