<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToBuquesTable extends Migration
{
    public function up()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('autonomia_horas');
        });
    }

    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
}
