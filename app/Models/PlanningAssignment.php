<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanningAssignment extends Model
{
    protected $fillable = [
        'planning_model_id',
        'employee_id',
        'start_date',
        'end_date',
        'status',
        'validated_by',
        'validated_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'validated_at' => 'datetime',
    ];

    public function planningModel(): BelongsTo
    {
        return $this->belongsTo(PlanningModel::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Le validateur est généralement un Chef de Plateau (CP).
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'validated_by');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(PlanningHistory::class);
    }
}