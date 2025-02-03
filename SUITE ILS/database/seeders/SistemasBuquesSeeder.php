<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SistemasBuqueSeeder extends Seeder
{
    public function run()
    {
        $sistemas = [
            ['codigo' => '200', 'nombre' => 'SISTEMA DE PROPULSIÓN'],
            ['codigo' => '240', 'nombre' => 'SISTEMA DE TRANSMISIÓN Y DE PROPULSIÓN'],
            ['codigo' => '261', 'nombre' => 'SISTEMA DE COMBUSTIBLE'],
            ['codigo' => '256', 'nombre' => 'SISTEMA DE ENFRIAMIENTO POR AGUA DE MAR'],
            ['codigo' => '264', 'nombre' => 'SISTEMA RELLENO, TRASIEGO Y PURIFICACIÓN DEL ACEITE LUBRICANTE'],
            ['codigo' => '300', 'nombre' => 'SISTEMA DE GENERACIÓN'],
            ['codigo' => '311', 'nombre' => 'GENERACIÓN DE ENERGÍA'],
            ['codigo' => '313', 'nombre' => 'BATERÍAS Y SUS MEDIOS AUXILIARES'],
            ['codigo' => '314', 'nombre' => 'EQUIPO CONVERTIDOR DE ENERGÍA'],
            ['codigo' => '420', 'nombre' => 'SISTEMA DE NAVEGACIÓN Y COMUNICACIONES'],
            ['codigo' => '422', 'nombre' => 'SISTEMA DE LUCES DE NAVEGACIÓN'],
            ['codigo' => '439', 'nombre' => 'SISTEMA DE MONITOREO'],
            ['codigo' => '441', 'nombre' => 'SISTEMA DE COMUNICACIONES'],
            ['codigo' => '443', 'nombre' => 'SISTEMAS VISUALES Y FÓNICOS'],
            ['codigo' => '463', 'nombre' => 'ECOSONDA MULTIHAZ'],
            ['codigo' => '512', 'nombre' => 'SISTEMAS DE AIRE ACONDICIONADO'],
            ['codigo' => '513', 'nombre' => 'SISTEMA DE VENTILACIÓN'],
            ['codigo' => '521', 'nombre' => 'SISTEMAS DE CONTRAINCENDIOS DE AGUA SALADA'],
            ['codigo' => '529', 'nombre' => 'SISTEMA DE ACHIQUE Y LASTRE'],
            ['codigo' => '533', 'nombre' => 'SISTEMA DE AGUA FRESCA'],
            ['codigo' => '555', 'nombre' => 'SISTEMA DE EXTINCIÓN DE INCENDIOS DE CUARTO DE MAQUINAS'],
            ['codigo' => '593', 'nombre' => 'SISTEMA DE AGUAS NEGRAS'],
            ['codigo' => '573', 'nombre' => 'SISTEMA DE MANIPULACIÓN DE CARGA'],
            ['codigo' => '583', 'nombre' => 'BOTES Y SISTEMAS DE ESTIBA'],
            ['codigo' => '600', 'nombre' => 'HABITABILIDAD Y EQUIPAMIENTO'],
            ['codigo' => '625', 'nombre' => 'LIMPIA PARABRISAS'],
            ['codigo' => '651', 'nombre' => 'ELEMENTOS PARA LA COCINA'],
            ['codigo' => '663', 'nombre' => 'ELEMENTOS DE ALMACENAMIENTO DE VÍVERES'],
        ];

        foreach ($sistemas as $sistema) {
            \DB::table('sistemas_buque')->insert([
                'codigo' => $sistema['codigo'],
                'nombre' => $sistema['nombre'],
                'buque_id' => 71, // Asociar al buque con ID 71
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
