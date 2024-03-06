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
        Schema::create('koordinats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')->nullable()
                ->constrained('opds')
                ->onUpdate('RESTRICT')
                ->onDelete('SET NULL');
            $table->string('alamat');
            $table->string('latitude'); // Tambahkan kolom latitude
            $table->string('longitude'); // Tambahkan kolom longitude
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('koordinats', function (Blueprint $table) {
            $table->dropForeign(['opd_id']); // Hapus kunci asing opd_id
        });

        Schema::dropIfExists('koordinats');
    }
};
