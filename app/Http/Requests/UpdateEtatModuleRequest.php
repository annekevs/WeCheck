<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEtatModuleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'etat' => 'required|in:actif,inactif',
            'date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'etat.required' => 'L\'état est obligatoire.',
            'date.required' => 'La date est obligatoire.',
        ];
    }
}
