<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonneeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autorise la requête
    }

    public function rules()
    {
        return [
            'module_id' => 'required|exists:modules,id',  // Assurez-vous que le module existe
            'valeur' => 'required|numeric',
            'duree_fonctionnement' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'module_id.required' => 'Le module est obligatoire.',
            'valeur.required' => 'La valeur mesurée est obligatoire.',
            'duree_fonctionnement.required' => 'La durée de fonctionnement est obligatoire.',
        ];
    }
}
