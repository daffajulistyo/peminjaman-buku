<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cutis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('keterangan');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    public function down()
    {
        Schema::dropIfExists('cutis');
    }
};
