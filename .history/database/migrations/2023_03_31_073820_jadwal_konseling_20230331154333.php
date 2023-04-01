<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JadwalKonseling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("JadwalKonseling", function(Blueprint $table){
            $table->id("id_jk");
            $table->unsignedBigInteger("id_konselor");
            $table->string("keterangan");
            $table->integer("minggu");
            $table->integer("bulan");
            $table->integer("tahun");

            $table->foreign("id_konselor")->)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
