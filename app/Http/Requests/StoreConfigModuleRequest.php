<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfigModuleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'module_id' => 'required|exists:modules,id',
            'seuil_min' => 'nullable|numeric',
            'seuil_max' => 'nullable|numeric',
            'frequence_mesure' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'module_id.required' => 'Le module est obligatoire.',
            'seuil_min.numeric' => 'Le seuil minimum doit être un nombre.',
            'seuil_max.numeric' => 'Le seuil maximum doit être un nombre.',
            'frequence_mesure.integer' => 'La fréquence de mesure doit être un entier.',
        ];
    }
}
