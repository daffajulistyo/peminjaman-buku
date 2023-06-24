<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
        });
    }

    public function down()
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->dropColumn(['tanggal_peminjaman', 'tanggal_pengembalian']);
        });
    }
};
