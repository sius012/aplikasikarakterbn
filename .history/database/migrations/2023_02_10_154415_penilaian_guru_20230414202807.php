<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("penilaian_guru", function (Blueprint $table) {
            $table->id("id_pg");
            $table->integer("id_angkatan");
            $table->unsignedBigInteger("id_jurusan");
            $table->unsignedInteger("id_penilai");
            $table->string("keterangan");
            $table->dat("tanggal_penilaian");


            $table->foreign("id_angkatan")->references("id_angkatan")->on("angkatan");
            $table->foreign("id_jurusan")->references("id_jurusan")->on("jurusan");
            $table->foreign("id_penilai")->references("id")->on("users");
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
};
