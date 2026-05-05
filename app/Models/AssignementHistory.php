<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentHistory extends Model
{
    // Rappel : Ta migration utilise 'assignment_historys'
    protected $table = 'assignment_historys';

    protected $fillable = [
        'assignment_id',
        'employee_id',
        'old_manager_id',
        'new_manager_id',
        'old_campaign_id',
        'new_campaign_id',
        'action_type',
        'changed_by',
        'reason'
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function oldManager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'old_manager_id');
    }

    public function newManager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'new_manager_id');
    }

    public function oldCampaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'old_campaign_id');
    }

    public function newCampaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'new_campaign_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
