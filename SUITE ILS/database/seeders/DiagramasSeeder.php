<?php

// database/seeders/DiagramasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiagramasSeeder extends Seeder
{
    public function run()
    {
        DB::table('diagramas')->insert([
            ['ruta' => 'diagramas/0.png'],
            ['ruta' => 'diagramas/100.png'],
            ['ruta' => 'diagramas/110.png'],
            ['ruta' => 'diagramas/1110.png'],
            ['ruta' => 'diagramas/10100.png'],
            ['ruta' => 'diagramas/10101.png'],
            ['ruta' => 'diagramas/10111.png'],
            ['ruta' => 'diagramas/101100.png'],
            ['ruta' => 'diagramas/101101.png'],
            ['ruta' => 'diagramas/111100.png'],
            ['ruta' => 'diagramas/111101.png'],
            ['ruta' => 'diagramas/111111.png'],
        ]);
    }
}

