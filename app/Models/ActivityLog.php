<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 
        'action', 
        'model_type', 
        'model_id', 
        'description', 
        'ip_address'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Permet de récupérer l'objet lié (Campaign, Assignment, etc.) dynamiquement
    public function subject(): MorphTo
    {
        return $this->morphTo(null, 'model_type', 'model_id');
    }
}
