<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDebetAndKreditFromDetailJurnalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_jurnal', function (Blueprint $table) {
            $table->double('kredit')->default(0)->after('no_akun');
            $table->double('debit')->default(0)->after('kredit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_jurnal', function (Blueprint $table) {
            $table->dropColumn('kredit');
            $table->dropColumn('debit');
        });
    }
}
