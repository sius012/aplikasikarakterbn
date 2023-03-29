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
        Schema::create("detail_siswa", function(Blueprint $table){
            $table->id("id_ds");
            $table->string("nis",25);
            $table->string("nik")->nullable();
            $table->string("hobi")->nullable();
            $table->string("nama_ayah")->nullable();
            $table->string("nama_ibu")->nullable();
            $table->string("nama_wali")->nullable();
            $table->string("pekerjaan_ayah")->nullable();
            $table->string("pekerjaan_ibu")->nullable();
            $table->string("pekerjaan_wali")->nullable();
            $table->string("alamat_ayah")->nullable();
            $table->string("alamat_ibu")->nullable();
            $table->string("alamat_wali")->nullable();
            $table->string("telp_ayah")->nullable();
            $table->string("telp_ibu")->nullable();
            $table->string("telp_wali")->nullable();
            $table->string("hub_wali")->nullable();
            $table->foreign("nis")->references("nis")->on("siswa");
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
