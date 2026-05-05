<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activityLogs = [
            [
                'user_id' => User::first()->id,
                'action' => 'create',
                'model_type' => 'Campaign',
                'model_id' => 1,
                'description' => 'Création de la campagne Refonte Site E-commerce',
                'ip_address' => '192.168.1.100',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'create',
                'model_type' => 'Employee',
                'model_id' => 1,
                'description' => 'Ajout d\'un nouvel employé Jean Dupont',
                'ip_address' => '192.168.1.100',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'update',
                'model_type' => 'Assignment',
                'model_id' => 1,
                'description' => 'Modification de l\'affectation de Marie Martin',
                'ip_address' => '192.168.1.101',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'create',
                'model_type' => 'PlanningModel',
                'model_id' => 1,
                'description' => 'Création du modèle de planning Semaine Standard 40h',
                'ip_address' => '192.168.1.100',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'delete',
                'model_type' => 'Timesheet',
                'model_id' => 5,
                'description' => 'Suppression d\'une feuille de temps erronée',
                'ip_address' => '192.168.1.102',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'update',
                'model_type' => 'Employee',
                'model_id' => 3,
                'description' => 'Mise à jour du statut de Pierre Durand',
                'ip_address' => '192.168.1.100',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'create',
                'model_type' => 'Position',
                'model_id' => 8,
                'description' => 'Ajout de la position Testeur QA',
                'ip_address' => '192.168.1.103',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'update',
                'model_type' => 'Campaign',
                'model_id' => 3,
                'description' => 'Changement de statut de la campagne Migration Cloud Infrastructure',
                'ip_address' => '192.168.1.100',
            ],
        ];

        foreach ($activityLogs as $activityLog) {
            ActivityLog::create($activityLog);
        }
    }
}
