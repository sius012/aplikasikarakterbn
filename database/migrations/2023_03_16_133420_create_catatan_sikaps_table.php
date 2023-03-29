<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanSikapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_sikap', function (Blueprint $table) {
            $table->id("id_cs");
            $table->unsignedBigInteger("id_penilai");
            $table->string("nis_siswa");
            $table->unsignedBigInteger("id_kategori");
            $table->string("keterangan");
            $table->enum("visibilitas", ["Asrama", "Sekolah", "Semua"]);
            $table->dateTime("tanggal");

            $table->foreign("nis_siswa")->references("nis")->on("siswa");
            $table->foreign("id_kategori")->references("id_kategori")->on("kategori");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catatan_sikaps');
    }
}
