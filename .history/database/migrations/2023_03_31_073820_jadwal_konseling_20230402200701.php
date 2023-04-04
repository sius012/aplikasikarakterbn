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
            $table->unsignedInteger("id_konselor");
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
            $table->integer("hari");
            $table->time("dari");
            $table->time("sampai");
            $table->foreign("id_jk")->references("id_jk")->on("jadwal_konseling");
        });

        Schema::create("billing_konseling", function(Blueprint $table){
            $table->id("id_bk");
            $table->unsignedBigInteger("id_djk");
            $table->string("keterangan_siswa");
            $table->string("catatan_konselor")->nullable();
            $table->string("tempat")->nullable();
            $table->enum("status", ["Dipesan", "Selesai", "Reschedule"]);
            $table->time("r_dari")->nullable();
            $table->time("r_sampai")->nullable();

            $table->foreign("id_djk")->references("id_djk")->on("detail_jk");
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
