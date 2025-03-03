<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ModuleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $modules = Module::latest()->paginate(5);
        foreach ($modules as $module) {
            $module->valeur = $module->donnees()->latest()->first();
            $module->duree = $module->getDuree();
            $module->total_donnees = $module->getTotalDonnees();
        }
        return view('modules.index', [
            'modules' => $modules
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function getAllModules()
    {
        $modules = Module::all();

        foreach ($modules as $module) {
            $module->valeur = $module->donnees()->latest()->first();
            $module->duree = $module->getDuree();
            $module->total_donnees = $module->getTotalDonnees();
        }

        return response()->json($modules);
    }

    public function getOneModule($id)
    {
        $module = Module::find($id);

        if (!$module) {
            return response()->json(['message' => 'Module non trouvé'], 404);
        }
        $module->valeur = $module->donnees()->latest()->first();
        $module->duree = $module->getDuree();
        $module->total_donnees = $module->getTotalDonnees();

        return response()->json($module);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModuleRequest $request): RedirectResponse
    {
        Module::create($request->all());

        return
            redirect()
            ->route('modules.index')
            ->withSuccess('Module ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module): View
    {
        // Récupère le module avec ses données et son historique paginé
        $module = Module::with('donnees', 'etats')->findOrFail($module->id);

        // Paginer les données associées au module (par exemple 10 données par page)
        $donnees = $module->donnees()->paginate(10);

        // Paginer l'historique des modules
        $etats = $module->etats()->paginate(10);

        return view('modules.show', compact('module', 'donnees', 'etats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module): View
    {
        return view('modules.edit', [
            'module' => $module
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModuleRequest $request, Module $module): RedirectResponse
    {
        $module->update($request->all());
        return redirect()->back()
            ->withSuccess('Module is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module): RedirectResponse
    {
        $module->delete();
        return redirect()->route('modules.index')
            ->withSuccess('Module is deleted successfully.');
    }

    /**
     * Get Realtime data
     */
    public function getRealTimeData()
    {
        // Simulate IoT sensor data (random value)
        $value = rand(20, 35);
        $newTime = date('Y/m/d H:i:s'); // Get current datetime

        return Response::json([
            'success' => true,
            'value' => $value,
            'time' => "current time is " . $newTime
        ], 200);
    }

    /**
     * Generate Realtime data and save it to the database
     */
    public function generateRealTimeData(Module $module)
    {
        // Simulate IoT sensor data (random value)
        $value = rand(20, 35);
        $newTime = date('Y/m/d H:i:s'); // Get current datetime

        return Response::json([
            'success' => true,
            'value' => $value,
            'time' => "current time is " . $newTime
        ], 200);
    }
}
