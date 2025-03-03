<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => [
                'required',
                'string',
                'max:250',
                Rule::unique("modules")->where(function ($query) {
                    $query->where("nom", $this->nom);
                })
            ],
            'description' => 'nullable|string',
            'emplacement' => 'required|string',
            'date_ajout' => 'required',
            'type' => 'required | string | max:100',
            'unite' => 'required | string | max:20'
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
            'nom.required' => 'Le nom du module est obligatoire.',
            'emplacement.required' => 'L\'emplacement du module est obligatoire.',
            'date_ajout.required' => 'Veuillez renseigner la date à laquelle le module a été installé',
            'type.required' => 'Veuillez renseigner le type de mesure effectué par le module',
            'unite.required' => 'Veuillez renseigner l\'unite de mesure utilisé par le module',
        ];
    }
}
