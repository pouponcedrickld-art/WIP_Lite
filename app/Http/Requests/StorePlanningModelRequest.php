<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanningModelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:planning_models,name',
            'description' => 'nullable|string',
            'monday_hours' => 'required|numeric|min:0|max:24',
            'tuesday_hours' => 'required|numeric|min:0|max:24',
            'wednesday_hours' => 'required|numeric|min:0|max:24',
            'thursday_hours' => 'required|numeric|min:0|max:24',
            'friday_hours' => 'required|numeric|min:0|max:24',
            'saturday_hours' => 'required|numeric|min:0|max:24',
            'sunday_hours' => 'required|numeric|min:0|max:24',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du modèle est obligatoire.',
            'name.unique' => 'Ce nom de modèle existe déjà.',
            '*.required' => 'Ce champ est obligatoire.',
            '*.numeric' => 'La valeur doit être un nombre.',
            '*.min' => 'La valeur minimale est 0.',
            '*.max' => 'La valeur maximale est 24h par jour.',
        ];
    }
}