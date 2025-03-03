<?php

namespace App\Http\Controllers;

use App\Models\Donnee;
use App\Models\Module;
use App\Http\Requests\StoreDonneeRequest;
use App\Http\Requests\UpdateDonneeRequest;

class DonneeController extends Controller
{
    // Afficher toutes les données pour un module spécifique
    public function index()
    {
        $donnees = Donnee::with('module')->latest()->paginate(50);;
        return view('donnees.index', compact('donnees'));
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $donneeModules = Donnee::with('module')->latest()->paginate(50);
        return response()->json($donneeModules);
    }

    // Afficher le formulaire pour ajouter une donnée
    public function create(Module $module)
    {
        return view('donnees.create', compact('module'));
    }

    // Enregistrer une nouvelle donnée pour un module
    public function store(StoreDonneeRequest $request, Module $module)
    {
        $module->donnees()->create($request->validated());
        return redirect()->route('donnees.index', $module)->with('success', 'Donnée ajoutée avec succès!');
    }

    // Afficher une donnée spécifique
    public function show(Donnee $donnee)
    {
        return view('donnees.show', compact('donnee'));
    }

    // Afficher le formulaire pour modifier une donnée
    public function edit(Donnee $donnee)
    {
        return view('donnees.edit', compact('donnee'));
    }

    // Mettre à jour une donnée spécifique
    public function update(UpdateDonneeRequest $request, Donnee $donnee)
    {
        $donnee->update($request->validated());
        return redirect()->route('donnees.index', $donnee->module)->with('success', 'Donnée mise à jour avec succès!');
    }

    // Supprimer une donnée
    public function destroy(Donnee $donnee)
    {
        $donnee->delete();
        return redirect()->route('donnees.index', $donnee->module)->with('success', 'Donnée supprimée avec succès!');
    }
}
