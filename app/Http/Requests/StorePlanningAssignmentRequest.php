<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanningAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'planning_model_id' => 'required|exists:planning_models,id',
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'planning_model_id.required' => 'Le modèle de planning est obligatoire.',
            'planning_model_id.exists' => 'Ce modèle de planning n\'existe pas.',
            'employee_id.required' => 'L\'employé est obligatoire.',
            'employee_id.exists' => 'Cet employé n\'existe pas.',
            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.date' => 'La date de début est invalide.',
            'end_date.date' => 'La date de fin est invalide.',
            'end_date.after' => 'La date de fin doit être après la date de début.',
        ];
    }
}