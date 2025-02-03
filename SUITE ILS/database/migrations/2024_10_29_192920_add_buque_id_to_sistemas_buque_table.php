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
        Schema::table('sistemas_buque', function (Blueprint $table) {
            $table->unsignedBigInteger('buque_id')->after('id');
            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sistemas_buque', function (Blueprint $table) {
            $table->dropForeign(['buque_id']);
            $table->dropColumn('buque_id');
        });
    }
};
