<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlamatSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alamat_siswas', function (Blueprint $table) {
            $table->id();
            $table->string("nis_siswa");
            $table->string("alamat")->nullable();
            $table->string("rt")->nullable();
            $table->string("rw")->nullable();
            $table->string("dusun")->nullable();
            $table->string("kelurahan")->nullable();
            $table->string("kecamatan")->nullable();
            $table->string("kode_pos")->nullable();

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
        Schema::dropIfExists('alamat_siswas');
    }
}
