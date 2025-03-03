<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Models\User;
use App\Notifications\ModuleNouvelEtat;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Récupérer toutes les notifications pour un utilisateur.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllNotifications(Request $request)
    {
        // Récupérer l'utilisateur authentifié ou un autre utilisateur spécifique
        $user = $request->user(); // Ou User::find($userId) si vous ciblez un utilisateur spécifique

        // Récupérer toutes les notifications non lues de cet utilisateur
        $notifications = $user->notifications;

        return response()->json($notifications);
    }

    /**
     * Récupérer les notifications pour un module spécifique.
     *
     * @param Request $request
     * @param int $moduleId
     * @return \Illuminate\Http\Response
     */
    public function getNotificationsForModule(Request $request, $moduleId)
    {
        // Récupérer l'utilisateur authentifié ou un autre utilisateur spécifique
        $user = $request->user(); // Ou User::find($userId) si vous ciblez un utilisateur spécifique

        // Récupérer les notifications qui contiennent le module_id spécifique dans le champ 'data'
        $notifications = $user->notifications()
            ->whereJsonContains('data->module_id', $moduleId)
            ->get();

        return response()->json($notifications);
    }

    /**
     * Marquer une notification comme lue.
     *
     * @param Request $request
     * @param int $notificationId
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Request $request, $notificationId)
    {
        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        // Trouver la notification spécifiée par ID
        $notification = $user->notifications()->findOrFail($notificationId);

        // Marquer la notification comme lue
        $notification->markAsRead();

        return response()->json([
            'message' => 'Notification marquée comme lue.',
            'notification' => $notification
        ]);
    }

    /**
     * Supprimer une notification.
     *
     * @param Request $request
     * @param int $notificationId
     * @return \Illuminate\Http\Response
     */
    public function deleteNotification(Request $request, $notificationId)
    {
        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        // Trouver la notification spécifiée par ID
        $notification = $user->notifications()->findOrFail($notificationId);

        // Supprimer la notification
        $notification->delete();

        return response()->json([
            'message' => 'Notification supprimée avec succès.'
        ]);
    }

    /**
     * Récupérer les notifications non lues d'un utilisateur.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getUnreadNotifications(Request $request)
    {
        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        // Récupérer les notifications non lues de l'utilisateur
        $notifications = $user->unreadNotifications;

        return response()->json($notifications);
    }

    /**
     * Marquer toutes les notifications comme lues pour un utilisateur.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead(Request $request)
    {
        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        // Marquer toutes les notifications comme lues
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'Toutes les notifications ont été marquées comme lues.'
        ]);
    }

    /**
     * Créer une notification pour un utilisateur.
     *
     * @param StoreNotificationRequest $request
     * @param int $userId
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request, $userId)
    {
        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($userId);

        // Validation des données est automatiquement effectuée grâce à StoreNotificationRequest

        // Créer la notification
        $notification = new ModuleNouvelEtat(
            $request->module_id,
            $request->message
        );

        // Envoyer la notification à l'utilisateur
        $user->notify($notification);

        return response()->json([
            'message' => 'Notification envoyée avec succès.'
        ]);
    }
}
