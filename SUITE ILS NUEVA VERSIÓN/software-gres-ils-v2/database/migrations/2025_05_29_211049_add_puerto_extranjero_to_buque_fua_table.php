<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('buque_fua', function (Blueprint $table) {
            $table->integer('puerto_extranjero')->nullable()->after('disponible_misiones_5');
        });
    }

    public function down(): void
    {
        Schema::table('buque_fua', function (Blueprint $table) {
            $table->dropColumn('puerto_extranjero');
        });
    }
};
