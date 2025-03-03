<?php

namespace App\Http\Controllers;

use App\Models\EtatModule;
use App\Http\Requests\StoreEtatModuleRequest;
use App\Http\Requests\UpdateEtatModuleRequest;
use App\Models\Module;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\ModuleNouvelEtat;

class EtatModuleController extends Controller
{
    // Afficher l'etatModule des états des modules
    public function index()
    {
        $etatModules = EtatModule::with('module')->latest()->paginate(50);
        foreach ($etatModules as $etatModule) {
            $etatModule->valeur = $etatModule->module->donnees()->latest()->first()->valeur;
        }
        return view('etat_modules.index', compact('etatModules'));
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $etatModules = EtatModule::with('module')->latest()->paginate(50);
        foreach ($etatModules as $etatModule) {
            $etatModule->valeur = $etatModule->module->donnees()->latest()->first()->valeur;
        }

        return response()->json($etatModules);
    }


    // Ajouter un état pour un module
    public function store(StoreEtatModuleRequest $request, Module $module)
    {
        // Créer un nouvel état pour le module
        $etatModule = $module->etats()->create($request->validated());
        var_dump('module status changed');
        dump("test");
        // Vérifier l'état du module et envoyer une notification en conséquence
        if ($etatModule->etat === 'panne') {
            var_dump('module en panne');
            // Si l'état est "panne", envoyer une notification pour la panne
            $this->sendModuleNotification($module, 'panne');
        } elseif ($etatModule->etat === 'actif') {
            // Si l'état est "actif", envoyer une notification pour le retour en fonction
            $this->sendModuleNotification($module, 'actif');
        }

        return response()->json(['message' => 'État du module mis à jour et notification envoyée.']);
    }

    /**
     * Envoyer une notification à tous les utilisateurs pour un changement d'état du module
     */
    protected function sendModuleNotification(Module $module, $etat)
    {
        // Récupérer tous les utilisateurs
        $users = User::all();
        Notification::send($users, new ModuleNouvelEtat($module, $etat)); // Envoyer la notification à chaque utilisateur

    }
}
