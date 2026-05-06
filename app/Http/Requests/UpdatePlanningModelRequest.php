<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanningModelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255|unique:planning_models,name,' . $this->route('planning_model'),
            'description' => 'nullable|string',
            'monday_hours' => 'sometimes|numeric|min:0|max:24',
            'tuesday_hours' => 'sometimes|numeric|min:0|max:24',
            'wednesday_hours' => 'sometimes|numeric|min:0|max:24',
            'thursday_hours' => 'sometimes|numeric|min:0|max:24',
            'friday_hours' => 'sometimes|numeric|min:0|max:24',
            'saturday_hours' => 'sometimes|numeric|min:0|max:24',
            'sunday_hours' => 'sometimes|numeric|min:0|max:24',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Ce nom de modèle existe déjà.',
            '*.numeric' => 'La valeur doit être un nombre.',
            '*.min' => 'La valeur minimale est 0.',
            '*.max' => 'La valeur maximale est 24h par jour.',
        ];
    }
}