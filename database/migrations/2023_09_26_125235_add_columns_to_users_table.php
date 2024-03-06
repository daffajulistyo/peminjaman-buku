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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable();
            $table->enum('status', ['PNS', 'PPPK', 'Honor Daerah', 'Kontrak'])->nullable();
            $table->string('nohp')->nullable();
            $table->string('uuid')->nullable();
            $table->string('akses')->default('1')->comments('1-Apk,2-Web');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nip', 'status', 'nohp','android_id']);
        });
    }
};
