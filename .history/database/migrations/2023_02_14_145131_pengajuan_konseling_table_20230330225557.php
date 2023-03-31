<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengajuanKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("pengajuan_konseling", function(Blueprint $table){
            $table->id("id_pk");
            $table->unsignedInteger("id_konselor");
            $table->string("nis_siswa");
            $table->string("keterangan");
            $table->string("catatan_konselor")->nullable();
            $table->string("status")->default("Menunggu");
            $table->dateTime("tanggal", $precision=0);
            $table->dateTime("tanggal_ck", $precision=0)->nullable();
            $table->foreign("id_konselor")->references("id")->on("users");
            $table->foreign("nis_siswa")->references("nis")->on("siswa");
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
