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
        Schema::table('buques', function (Blueprint $table) {
            $table->dropForeign(['colab_id']);
            $table->dropColumn('colab_id');
        });
    }
    
    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->unsignedBigInteger('colab_id')->nullable();
            $table->foreign('colab_id')->references('id')->on('colaboradores')->onDelete('cascade');
        });
    }
};
   