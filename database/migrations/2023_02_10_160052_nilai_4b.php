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
        Schema::create("aspek_4b", function (Blueprint $table) {
            $table->id("id_aspek");
            $table->integer("no_aspek");
            $table->string("keterangan");
            $table->string("point");
             $table->string("no_point");
            $table->string("subpoint");
            $table->string("no_subpoint");
            $table->timestamps();
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
