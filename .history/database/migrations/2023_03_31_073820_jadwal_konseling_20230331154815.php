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
        Schema::create("jadwal_konseling", function(Blueprint $table){
            $table->id("id_jk");
            $table->unsignedBigInteger("id_konselor");
            $table->string("keterangan");
            $table->integer("minggu");
            $table->integer("bulan");
            $table->integer("tahun");
            $table->enum("status", ["Selesai","Berjalan"]);

            $table->foreign("id_konselor")->references("id")->on("users");
        });

        Schema::create("detail_jk", function(Blueprint $table){
            $table->id("id_djk");
            $table->unsignedBigInteger("id_jk");
            $table->string();
            $table->integer("minggu");
            $table->integer("bulan");
            $table->integer("tahun");

            $table->foreign("id_jk")->references("id_jk")->on("jadwal_konseling");
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
