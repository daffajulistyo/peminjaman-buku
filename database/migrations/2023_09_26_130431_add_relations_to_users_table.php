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
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('opd_id')->nullable()
            ->constrained('opds')
            ->onUpdate('RESTRICT')
            ->onDelete('SET NULL');
            
        $table->foreignId('bidang_id')->nullable()
            ->constrained('bidangs')
            ->onUpdate('RESTRICT')
            ->onDelete('SET NULL');
            
        $table->foreignId('jabatan_id')->nullable()
            ->constrained('jabatans')
            ->onUpdate('RESTRICT')
            ->onDelete('SET NULL');
            
        $table->foreignId('pangkat_id')->nullable()
            ->constrained('pangkats')
            ->onUpdate('RESTRICT')
            ->onDelete('SET NULL');
    });
}


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['opd_id']);
            $table->dropForeign(['bidang_id']);
            $table->dropForeign(['jabatan_id']);
            $table->dropForeign(['pangkat_id']);
            $table->dropColumn(['opd_id', 'bidang_id', 'jabatan_id', 'pangkat_id']);
        });
    }
};
