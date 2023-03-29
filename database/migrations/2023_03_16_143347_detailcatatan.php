<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Detailcatatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("follow_up", function(Blueprint $table){
            $table->id("id_fu");
            $table->unsignedBigInteger("id_cs");
            $table->unsignedInteger("id_penulis");
            $table->string("catatan");
            $table->dateTime("tanggal");

            $table->foreign("id_cs")->references("id_cs")->on("catatan_sikap");
            $table->foreign("id_penulis")->references("id")->on("users");
        });

        Schema::create("lampiran", function(Blueprint $table){
            $table->id("id_lampiran");
            $table->unsignedBigInteger("id_cs");
            $table->string("nama_file");

            $table->foreign("id_cs")->references("id_cs")->on("catatan_sikap");
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
