<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherHasTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_has_teachings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("id_guru");
            $table->unsignedBigInteger("id_jurusan");
            $table->integer("id_angkatan");
            $table->string("sebagai");
            $table->date("dari");
            $table->date("sampai");
           
            $table->foreign("id_guru")->references("id")->on("users");
            $table->foreign("id_angkatan")->references("id_angkatan")->on("angkatan");
            $table->foreign("id_jurusan")->references("id_jurusan")->on("jurusan");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_has_teachings');
    }
}
