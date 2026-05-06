<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanningAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'planning_model_id' => 'sometimes|exists:planning_models,id',
            'employee_id' => 'sometimes|exists:employees,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'planning_model_id.exists' => 'Ce modèle de planning n\'existe pas.',
            'employee_id.exists' => 'Cet employé n\'existe pas.',
            'start_date.date' => 'La date de début est invalide.',
            'end_date.date' => 'La date de fin est invalide.',
            'end_date.after' => 'La date de fin doit être après la date de début.',
        ];
    }
}