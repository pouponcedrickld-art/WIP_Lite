<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanningHistory extends Model
{
   
    protected $table = 'planning_historys';

    protected $fillable = [
        'planning_assignment_id',
        'old_status',
        'new_status',
        'changed_by',
        'reason'
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(PlanningAssignment::class, 'planning_assignment_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}