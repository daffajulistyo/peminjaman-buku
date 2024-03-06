<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Tambahkan kolom user_id sebagai foreign key

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Hapus constraint foreign key
            $table->dropColumn('user_id'); // Hapus kolom user_id
        });
    }
};
