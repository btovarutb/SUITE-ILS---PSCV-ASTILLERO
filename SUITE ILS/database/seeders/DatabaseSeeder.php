<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Verificar si el usuario ya existe
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Llamar al seeder de SistemasEquipos
        $this->call(SistemasBuqueSeeder::class);

        // Luego ejecuta el seeder de BuqueSistemasBuque
        $this->call(BuqueSistemasBuqueSeeder::class);


    }
}
