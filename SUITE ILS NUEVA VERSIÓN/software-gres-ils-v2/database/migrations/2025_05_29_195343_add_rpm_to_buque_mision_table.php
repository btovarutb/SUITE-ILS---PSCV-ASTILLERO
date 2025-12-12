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
        Schema::table('buque_misiones', function (Blueprint $table) {
            $table->integer('rpm')->nullable()->after('potencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buque_misiones', function (Blueprint $table) {
            $table->dropColumn('rpm');
        });
    }
};

