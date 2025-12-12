<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuqueSistemasBuqueSeeder extends Seeder
{
    public function run()
    {
        // Obtenemos los sistemas_buque que pertenecen al buque con ID 71
        $sistemas = DB::table('sistemas_buque')
            ->where('buque_id', 71)
            ->get();

        // Iteramos sobre los sistemas y los insertamos en la tabla buque_sistemas_buque
        foreach ($sistemas as $sistema) {
            DB::table('buque_sistemas_buque')->insert([
                'buque_id' => 71, // ID del buque
                'sistemas_buque_id' => $sistema->id, // ID del sistema desde sistemas_buque
                'mec' => null, // Dejamos null según tu requerimiento
                'titulo' => null, // Dejamos null según tu requerimiento
                'image' => null, // Dejamos null según tu requerimiento
                'observaciones' => null, // Dejamos null según tu requerimiento
                'mision' => null, // Dejamos null según tu requerimiento
                'created_at' => now(), // Timestamp actual
                'updated_at' => now(), // Timestamp actual
            ]);
        }
    }
}
