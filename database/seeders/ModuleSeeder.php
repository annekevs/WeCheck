<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        DB::table('modules')->insert([
            [
                'nom' => 'Température',
                'description' => 'Module pour mesurer la température',
                'type' => 'Température',
                'unite' => '°C',
                'emplacement' => '123 Rue de la Technologie, Paris, Salle serveurs',
                'geolocalisation' => '48.8566, 2.3522',
                'en_panne' => false,
                'date_ajout' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'Vitesse du vent',
                'description' => 'Module pour mesurer la vitesse du vent',
                'type' => 'Vitesse',
                'unite' => 'm/s',
                'emplacement' => '45 Avenue de l\'Innovation, Paris, Toit de l\'immeuble',
                'geolocalisation' => '48.8566, 2.3522',
                'en_panne' => false,
                'date_ajout' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'Humidité',
                'description' => 'Module pour mesurer l\'humidité de l\'air',
                'type' => 'Humidité',
                'unite' => '%',
                'emplacement' => '78 Boulevard des Sciences, Paris, Bureau principal',
                'geolocalisation' => '48.8566, 2.3522',
                'en_panne' => false,
                'date_ajout' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'Pression atmosphérique',
                'description' => 'Module pour mesurer la pression atmosphérique',
                'type' => 'Pression',
                'unite' => 'hPa',
                'emplacement' => '56 Rue de la Recherche, Paris, Salle des machines',
                'geolocalisation' => '48.8566, 2.3522',
                'en_panne' => true,
                'date_ajout' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
