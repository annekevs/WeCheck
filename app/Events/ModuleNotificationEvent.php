<?php

namespace App\Events;

use App\Models\Module;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class ModuleNotificationEvent extends Notification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $module;
    public $etat;
    public $message;

    public function __construct(Module $module, $etat)
    {
        $this->module = $module;
        $this->module->duree = $module->getDuree();
        $this->etat = $etat;
        $this->message = $etat === 'panne'
            ? "Le module {$module->nom} est tombé en panne."
            : "Le module {$module->nom} est maintenant opérationnel.";
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
            'message' => $this->message,
            'module_id' => $this->module['id'],
        ];
    }

    // Diffusion en temps réel via Pusher
    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage([
            'message' => $this->message,
            'module_id' => $this->module->id,
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('etat-module-channel'),
        ];
    }

    public function broadcastAs()
    {
        return 'nouvel-etat';
    }
}
