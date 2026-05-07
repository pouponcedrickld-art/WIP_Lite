<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanningAssignmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee' => [
                'id' => $this->employee->id,
                'name' => $this->employee->first_name . ' ' . $this->employee->last_name,
                'matricule' => $this->employee->matricule,
            ],
            'planning_model' => [
                'id' => $this->planningModel->id,
                'name' => $this->planningModel->name,
                'total_hours' => $this->planningModel->total_hours,
            ],
            'start_date' => $this->start_date->format('d/m/Y'),
            'end_date' => $this->end_date?->format('d/m/Y'),
            'status' => $this->status,
            'validated_by' => $this->validator
                ? $this->validator->first_name . ' ' . $this->validator->last_name
                : null,
            'validated_at' => $this->validated_at?->format('d/m/Y H:i'),
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}