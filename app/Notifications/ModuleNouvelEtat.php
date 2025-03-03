<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ModuleNouvelEtat extends Notification
{
    use Queueable;

    public $module;
    public $etat;

    public function __construct($module, $etat)
    {
        $this->module = $module;
        $this->etat = $etat;
    }

    // Notification via base de données et broadcast (Pusher)
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    // Stockage en base de données
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->etat === 'panne'
                ? "Le module {$this->module->nom} est tombé en panne."
                : "Le module {$this->module->nom} est maintenant opérationnel.",
            'module_id' => $this->module->id,
        ];
    }

    // Diffusion en temps réel via Pusher
    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage([
            'message' => $this->etat === 'panne'
                ? "Le module {$this->module->nom} est tombé en panne."
                : "Le module {$this->module->nom} est maintenant opérationnel.",
            'module_id' => $this->module->id,
        ]);
    }
}
