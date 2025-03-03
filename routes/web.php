<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigModuleController;
use App\Http\Controllers\dashboard\Dashboard;
use App\Http\Controllers\DonneeController;
use App\Http\Controllers\EtatModuleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NotificationController;

// Main Page Route
Route::get('/', [Dashboard::class, 'index'])->name('dashboard-modules');

// Modules
Route::resource('modules', ModuleController::class);
Route::get('/modules-data', [ModuleController::class, 'getRealTimeData'])->name('modules.data');

// API ROUTES
Route::get('/api/modules', [ModuleController::class, 'getAllModules'])->name('api.modules.fetchAll');
Route::get('/api/modules/{id}', [ModuleController::class, 'getOneModule'])->name('api.modules.fetchOne');
Route::get('/api/modules/etats', [EtatModuleController::class, 'getAll'])->name('api.etat-modules.fetchAll');
Route::get('/api/modules/donnees', [DonneeController::class, 'getAll'])->name('api.donnee-modules.fetchAll');

// Routes pour l'historique d'état 
Route::get('/historique/etats', [EtatModuleController::class, 'index'])->name('etat_modules.index');

// Routes pour l'historique d'état (associé à un module)
Route::get('/historique/donnees', [DonneeController::class, 'index'])->name('donnees_modules.index');

// ******************************* NOTIFICATIONS ***********************************//

// Récupérer toutes les notifications
Route::get('/notifications', [NotificationController::class, 'getAllNotifications']);

// // Récupérer les notifications pour un module spécifique
// Route::get('/notifications/module/{moduleId}', [NotificationController::class, 'getNotificationsForModule']);

// // Marquer une notification comme lue
// Route::patch('/notifications/{notificationId}/read', [NotificationController::class, 'markAsRead']);

// // Supprimer une notification
// Route::delete('/notifications/{notificationId}', [NotificationController::class, 'deleteNotification']);

// // Récupérer les notifications non lues
// Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);

// // Marquer toutes les notifications comme lues
// Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

// ******************************************************************//

// Routes pour la configuration du module
Route::resource('modules/{module}/config_modules', ConfigModuleController::class);
