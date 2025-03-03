<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
  public function index()
  {
    $modules = Module::all();
    foreach ($modules as $module) {
      $module->valeur = $module->donnees()->latest()->first();
      $module->duree = $module->getDuree();
      $module->total_donnees = $module->getTotalDonnees();
    }
    return view('content.dashboard.index', compact('modules'));
  }
}
