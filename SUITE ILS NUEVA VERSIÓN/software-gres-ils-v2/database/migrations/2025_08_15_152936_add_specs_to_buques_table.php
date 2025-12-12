<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buques', function (Blueprint $table) {
            // Dimensiones (m)
            $table->decimal('eslora', 10, 2)->nullable()->after('descripcion');
            $table->decimal('manga', 10, 2)->nullable()->after('eslora');
            $table->decimal('puntal', 10, 2)->nullable()->after('manga');
            $table->decimal('calado_metros', 10, 2)->nullable()->after('puntal');
            $table->decimal('altura_mastil', 10, 2)->nullable()->after('calado_metros');
            $table->decimal('altura_maxima_buque', 10, 2)->nullable()->after('altura_mastil');

            // Identificación
            $table->string('tipo_material_construccion', 255)->nullable()->after('altura_maxima_buque');
            $table->string('sigla_internacional_unidad', 50)->nullable()->after('tipo_material_construccion');
            $table->string('plano_numero', 255)->nullable()->after('sigla_internacional_unidad');

            // Autonomías (sin días)
            $table->decimal('autonomia_millas_nauticas', 10, 2)->nullable()->after('autonomia_horas');

            // Desplazamientos (t)
            $table->decimal('desp_cond_1_peso_rosca', 12, 3)->nullable()->after('autonomia_millas_nauticas');
            $table->decimal('desp_cond_2_10_consumibles', 12, 3)->nullable()->after('desp_cond_1_peso_rosca');
            $table->decimal('desp_cond_3_minima_operacional', 12, 3)->nullable()->after('desp_cond_2_10_consumibles');
            $table->decimal('desp_cond_4_50_consumibles', 12, 3)->nullable()->after('desp_cond_3_minima_operacional');
            $table->decimal('desp_cond_5_optima_operacional', 12, 3)->nullable()->after('desp_cond_4_50_consumibles');
            $table->decimal('desp_cond_6_zarpe_plena_carga', 12, 3)->nullable()->after('desp_cond_5_optima_operacional');
        });
    }

    public function down(): void
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->dropColumn([
                'eslora',
                'manga',
                'puntal',
                'calado_metros',
                'altura_mastil',
                'altura_maxima_buque',
                'tipo_material_construccion',
                'sigla_internacional_unidad',
                'plano_numero',
                'autonomia_millas_nauticas',
                'desp_cond_1_peso_rosca',
                'desp_cond_2_10_consumibles',
                'desp_cond_3_minima_operacional',
                'desp_cond_4_50_consumibles',
                'desp_cond_5_optima_operacional',
                'desp_cond_6_zarpe_plena_carga',
            ]);
        });
    }
};
