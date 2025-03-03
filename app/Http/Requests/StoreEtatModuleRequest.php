<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtatModuleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'module_id' => 'required|exists:modules,id',
            'etat' => 'required|in:actif,panne',
        ];
    }

    public function messages()
    {
        return [
            'module_id.required' => 'Le module est obligatoire.',
            'etat.required' => 'L\'état du module est obligatoire.',
        ];
    }
}
