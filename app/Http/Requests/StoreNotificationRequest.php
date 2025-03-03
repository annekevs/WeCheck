
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Par défaut, tout utilisateur peut créer une notification
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la requête.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'module_id' => 'required|exists:modules,id', // Validation de l'existence du module
            'message' => 'required|string', // Validation du message
        ];
    }

    /**
     * Personnalisation des messages d'erreur de validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'module_id.required' => 'Le champ module_id est requis.',
            'module_id.exists' => 'Le module spécifié n\'existe pas.',
            'message.required' => 'Le message de la notification est requis.',
            'message.string' => 'Le message doit être une chaîne de caractères.',
        ];
    }
}
