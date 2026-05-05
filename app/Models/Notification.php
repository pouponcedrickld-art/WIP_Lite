<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];

    /**
     * Les attributs qui doivent être castés (convertis).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',        // Convertit automatiquement le JSON en tableau PHP
        'read_at' => 'datetime',  // Convertit la colonne en instance Carbon
    ];

    
}