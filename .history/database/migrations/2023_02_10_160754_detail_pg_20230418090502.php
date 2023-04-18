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
        Schema::create("detail_pg", function (Blueprint $table) {
            $table->id("id_dpg");
            $table->unsignedBigInteger("id_pg");
            $table->string("nis_siswa");
            $table->string("keterangan")->nullable();
            $table->string("followup")->nullable();


            $table->foreign("id_pg")->references("id_pg")->on("penilaian_guru")->onDelete('cascade');;
            $table->foreign("nis_siswa")->references("nis")->on("siswa");
        });

        Schema::create("aspek_dpg", function (Blueprint $table) {
            $table->id("id_adpg");
            $table->unsignedBigInteger("id_dpg");
            $table->unsignedBigInteger("id_aspek");
            $table->integer("nilai");
            $table->foreign("id_dpg")->references("id_dpg")->on("detail_pg");
            $table->foreign("id_aspek")->references("id_aspek")->on("aspek_4b");
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
