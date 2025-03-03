<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonneeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'valeur' => 'required|numeric',
            'duree_fonctionnement' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'valeur.required' => 'La valeur mesurée est obligatoire.',
            'valeur.numeric' => 'La valeur mesurée doit être un nombre.',
            'duree_fonctionnement.required' => 'La durée de fonctionnement est obligatoire.',
            'duree_fonctionnement.integer' => 'La durée de fonctionnement doit être un entier.',
        ];
    }
}
