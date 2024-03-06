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
        Schema::table('pegawais', function (Blueprint $table) {
            $table->unsignedBigInteger('opd_id')->nullable(); // Kolom opd_id sebagai kunci asing
            $table->foreign('opd_id')->references('id')->on('opds'); // Kunci asing ke tabel opd
        });
    }

    public function down()
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropForeign(['opd_id']); // Hapus kunci asing
            $table->dropColumn('opd_id'); // Hapus kolom opd_id
        });
    }
};
