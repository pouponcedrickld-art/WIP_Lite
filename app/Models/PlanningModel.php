<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanningModel extends Model
{
    protected $casts = [
        'monday_hours' => 'float',
        'tuesday_hours' => 'float',
        'wednesday_hours' => 'float',
        'thursday_hours' => 'float',
        'friday_hours' => 'float',
        'saturday_hours' => 'float',
        'sunday_hours' => 'float',
        'total_hours' => 'float',
        'created_by' => 'integer',
    ];
    protected $fillable = [
        'name',
        'description',
        'monday_hours',
        'tuesday_hours',
        'wednesday_hours',
        'thursday_hours',
        'friday_hours',
        'saturday_hours',
        'sunday_hours',
        'total_hours',
        'created_by'
    ];

    /**
     * Calcul automatique du total hebdomadaire avant la sauvegarde.
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            $model->total_hours =
                (float) $model->monday_hours + (float) $model->tuesday_hours +
                (float) $model->wednesday_hours + (float) $model->thursday_hours +
                (float) $model->friday_hours + (float) $model->saturday_hours +
                (float) $model->sunday_hours;
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(PlanningAssignment::class);
    }
}