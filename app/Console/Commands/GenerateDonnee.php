<?php

namespace App\Console\Commands;

use App\Events\ModuleNotificationEvent;
use Illuminate\Console\Command;
use App\Models\Donnee;
use App\Models\EtatModule;
use App\Models\Module;
use App\Models\User;
use App\Notifications\ModuleNouvelEtat;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;


class GenerateDonnee extends Command
{
    protected $signature = 'generate:donnees {frequence=2} {probabilite=5}';
    protected $description = 'Génère des données historiques pour les modules actifs avec une fréquence et une probabilité personnalisables';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $faker = Faker::create();
        $frequence = (int) $this->argument('frequence'); // Récupère la fréquence en secondes
        $probabilite = (int) $this->argument('probabilite'); // Récupère la probabilité de panne

        while (true) {
            $modules = Module::where('en_panne', false)->get();

            foreach ($modules as $module) {
                // Simuler une panne avec la probabilité définie
                if (rand(1, 100) <= $probabilite) {
                    EtatModule::create([
                        'module_id' => $module->id,
                        'etat' => 'panne',
                    ]);
                    $module->date_panne = now();
                    $module->en_panne = true;
                    $module->save();

                    $this->sendNotification($module, 'panne');
                    $this->info("Module {$module->id} est tombé en panne");
                    continue;
                }

                // Générer une nouvelle donnée
                $donnee = Donnee::create([
                    'module_id' => $module->id,
                    'valeur' => $faker->randomFloat(2, 10, 100),
                    'timestamp' => now(),
                ]);

                $moduleUpdated = [
                    'module' => $module,
                    'valeur' => $donnee->valeur,
                    'unite' => $module->unite,
                    'date_dernier_signal' => $donnee->created_at,
                    'en_panne' => $module->en_panne,
                    'total_donnees' => $module->getTotalDonnees(),
                    'duree' => $module->getDuree()
                ];

                $this->sendToPusher($moduleUpdated);
                $this->info("Données envoyées à Pusher");
            }

            // Réactiver les modules en panne avec la même probabilité
            $modulesEnPanne = Module::where('en_panne', true)->get();
            foreach ($modulesEnPanne as $module) {
                if (rand(1, 100) <= $probabilite) {
                    EtatModule::create([
                        'module_id' => $module->id,
                        'etat' => 'actif',
                    ]);
                    $module->date_reprise = now();
                    $module->en_panne = false;
                    $module->save();

                    $this->sendNotification($module, 'actif');
                    $this->info("Module {$module->id} est de nouveau actif");
                }
            }

            sleep($frequence); // Utilise la fréquence définie
        }
    }

    private function sendNotification($module, $etat)
    {
        $users = User::all();
        Notification::send($users, new ModuleNouvelEtat($module, $etat));
        broadcast(new ModuleNotificationEvent($module, $etat));
    }

    private function sendToPusher($donnee)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $pusher->trigger('donnees-channel', 'nouvelle-donnee', $donnee);
    }
}
