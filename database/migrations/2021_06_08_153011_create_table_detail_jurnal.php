<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDetailJurnal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_jurnal', function (Blueprint $table) {
            $table->id();
            $table->string('no_jurnal')->index();
            $table->string('no_akun')->index();
            $table->foreign('no_jurnal')->references('no_jurnal')->on('jurnal')->onDelete('cascade');
            $table->foreign('no_akun')->references('no_akun')->on('akun')->onDelete('cascade');
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
        Schema::dropIfExists('table_detail_jurnal');
    }
}
