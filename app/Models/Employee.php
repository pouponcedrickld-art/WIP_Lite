<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'matricule',
        'first_name',
        'last_name',
        'birth_date',
        'phone',
        'email',
        'address',
        'position_id',
        'salary_base',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'salary_base' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Accessor : Nom complet
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scopes
     */

    // Employés actifs
    public function scopeActive($query)
    {
        return $query->where('status', 'actif');
    }

    // Filtrer par poste
    public function scopeByPosition($query, $positionId)
    {
        return $query->where('position_id', $positionId);
    }

    /**
     * Relations
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function managedAssignments()
    {
        return $this->hasMany(Assignment::class, 'manager_id');
    }

    public function planningAssignments()
    {
        return $this->hasMany(PlanningAssignment::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}