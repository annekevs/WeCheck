<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfigModuleRequest;
use App\Models\ConfigModule;
use App\Models\Module;

class ConfigModuleController extends Controller
{ // Afficher la configuration d'un module
    public function show(Module $module)
    {
        $configModule = $module->configModule;
        return view('config_modules.show', compact('configModule', 'module'));
    }

    // Modifier la configuration d'un module
    public function edit(Module $module)
    {
        $configModule = $module->configModule;
        return view('config_modules.edit', compact('configModule', 'module'));
    }

    // Mettre à jour la configuration du module
    public function update(StoreConfigModuleRequest $request, Module $module)
    {
        $configModule = $module->configModule;
        $configModule->update($request->validated());
        return redirect()->route('config_modules.show', $module)->with('success', 'Configuration mise à jour avec succès!');
    }

    // Supprimer une configuration de module spécifique
    public function destroy(ConfigModule $configModule)
    {
        $configModule->delete();
        return redirect()->route('config_modules.index', $configModule->module)->with('success', 'Configuration supprimée avec succès!');
    }
}
