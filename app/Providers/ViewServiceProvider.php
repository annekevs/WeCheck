<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Enregistrer les services dans l'application.
     *
     * @return void
     */
    public function boot()
    {
        // Partager les notifications globales avec toutes les vues
        View::composer('*', function ($view) {
            dd('View composer exécuté');
            $notifications = [];
            $notifications = Notification::all();

            // Partager les notifications avec toutes les vues
            $view->with('notifications', $notifications);
        });
    }

    /**
     * Enregistrer les services dans l'application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
