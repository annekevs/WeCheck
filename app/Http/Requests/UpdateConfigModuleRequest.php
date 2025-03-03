<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfigModuleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'seuil_min' => 'nullable|numeric',
            'seuil_max' => 'nullable|numeric',
            'frequence_mesure' => 'nullable|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'seuil_min.numeric' => 'Le seuil minimum doit être un nombre.',
            'seuil_max.numeric' => 'Le seuil maximum doit être un nombre.',
            'frequence_mesure.integer' => 'La fréquence de mesure doit être un entier.',
            'frequence_mesure.min' => 'La fréquence de mesure doit être d\'au moins 1 seconde.',
        ];
    }
}
