<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sistema;

class SistemasSeeder extends Seeder
{
    public function run()
    {
        $sistemas = [
            ['grupo_constructivo' => '100', 'titulo' => 'Casco y Estructuras'],
            ['grupo_constructivo' => '200', 'titulo' => 'Máquinaria y Propulsión'],
            ['grupo_constructivo' => '300', 'titulo' => 'Planta Eléctrica'],
            ['grupo_constructivo' => '400', 'titulo' => 'Comando y Vigilancia'],
            ['grupo_constructivo' => '500', 'titulo' => 'Sistemas Auxiliares'],
            ['grupo_constructivo' => '600', 'titulo' => 'Acabados y Amoblamiento'],
            ['grupo_constructivo' => '700', 'titulo' => 'Armamento'],
        ];

        foreach ($sistemas as $sistema) {
            Sistema::create($sistema);
        }
    }
}
