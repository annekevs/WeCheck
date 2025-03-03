<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donnee;
use App\Models\Module;
use Faker\Factory as Faker;

class DonneeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $modules = Module::all();

        foreach ($modules as $module) {
            Donnee::create([
                'module_id' => $module->id,
                'valeur' => $faker->randomFloat(2, 10, 50), // Valeur aléatoire entre 10 et 50
                'created_at' => now(),
            ]);
        }
    }
}
