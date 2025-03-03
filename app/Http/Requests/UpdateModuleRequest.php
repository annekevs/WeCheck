<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateModuleRequest extends FormRequest
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
        ];
    }
}
