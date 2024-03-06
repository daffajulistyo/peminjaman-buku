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
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('question_image')->nullable();
            $table->string('answer_image')->nullable();
        });
    }

    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('question_image');
            $table->dropColumn('answer_image');
        });
    }
};
