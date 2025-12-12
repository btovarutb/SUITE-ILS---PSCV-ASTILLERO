<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMisionesToBuquesTable extends Migration
{
    public function up()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->json('misiones')->nullable();
        });
    }

    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->dropColumn('misiones');
        });
    }
}

