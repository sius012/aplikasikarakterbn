<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id("id_notif");
            $table->string('judul_notif');
            $table->string('isi_notif');
            $table->string('tanggal');
            $table->unsignedInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
