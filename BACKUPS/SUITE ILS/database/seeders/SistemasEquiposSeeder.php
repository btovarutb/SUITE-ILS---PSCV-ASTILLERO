<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SistemasEquipos;

class SistemasEquiposSeeder extends Seeder
{
    public function run()
    {
        $equipos = [
            ['mfun' => '233', 'titulo' => 'MAIN PROPULSION'],
            ['mfun' => '256', 'titulo' => 'CIRCULATING AND COOLING SEAWATER SYSTEM'],
            ['mfun' => '261', 'titulo' => 'MAIN PROPULSION FUEL TANKS'],
            ['mfun' => '264', 'titulo' => 'MAIN PROPULSION LUBE OIL SYSTEM'],
            ['mfun' => '301', 'titulo' => 'POWER DISTRIBUTION GENERAL ARRANGEMENT'],
            ['mfun' => '321', 'titulo' => 'AC ELECTRICAL'],
            ['mfun' => '320', 'titulo' => 'DC ELECTRICAL'],
            ['mfun' => '401', 'titulo' => 'COMMAND AND SURVEILLANCE GENERAL ARRANGEMENT'],
            ['mfun' => '583', 'titulo' => 'Shipping Cradle'],
            ['mfun' => '512', 'titulo' => 'HVAC SYSTEM'],
            ['mfun' => '513', 'titulo' => 'ER VENTILATION SYSTEM'],
            ['mfun' => '529', 'titulo' => 'BILGE SYSTEM PIPING'],
            ['mfun' => '533', 'titulo' => 'FRESH WATER SERVICE'],
            ['mfun' => '555', 'titulo' => 'ER FIRE SUPPRESSION'],
            ['mfun' => '593', 'titulo' => 'WASTE WATER SYSTEM'],
            ['mfun' => '583', 'titulo' => 'HOISTING AND TRANSPORTABILITY ARRANGEMENT'],
            ['mfun' => '600', 'titulo' => 'Antideslizante'],
            ['mfun' => '801', 'titulo' => 'General Arrangements Drawing'],
            ['mfun' => '801', 'titulo' => 'BOOKLET OF GENERAL PLANS'],
            ['mfun' => '995', 'titulo' => 'CUNA PARA CONSTRUCCION'],
        ];

        foreach ($equipos as $equipo) {
            SistemasEquipos::create($equipo);
        }
    }
}
