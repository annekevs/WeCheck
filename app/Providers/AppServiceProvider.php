<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // $notifications = Notification::latest()->take(5)->get();
        // // Vous pouvez également "décoder" les données ici si nécessaire
        // foreach ($notifications as $notification) {
        //     $notification->data = json_decode($notification->data, true);  // Décodez en tableau PHP
        // }
        // View::share('notifications',  $notifications);
    }
}
