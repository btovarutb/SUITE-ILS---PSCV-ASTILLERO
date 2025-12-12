<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GruposConstructivosSeeder extends Seeder
{
    public function run()
    {
        $grupos = [
            ['codigo' => '100', 'nombre' => 'Cascos y Estructuras'],
            ['codigo' => '200', 'nombre' => 'Maquinaria y Propulsión'],
            ['codigo' => '300', 'nombre' => 'Planta Eléctrica'],
            ['codigo' => '400', 'nombre' => 'Comando y Vigilancia'],
            ['codigo' => '500', 'nombre' => 'Sistemas Auxiliares'],
            ['codigo' => '600', 'nombre' => 'Acabados y Amoblamiento'],
            ['codigo' => '700', 'nombre' => 'Armamento'],
        ];

        DB::table('grupos_constructivos')->insert($grupos);
    }
}
