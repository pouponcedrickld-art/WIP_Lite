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
                'model_type' => 'Employee',
                'model_id' => 1,
                'description' => 'Création d\'un nouvel employé Jean Dupont',
                'ip_address' => '192.168.1.100',
            ],
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
                'action' => 'update',
                'model_type' => 'Employee',
                'model_id' => 2,
                'description' => 'Mise à jour des informations de Marie Martin',
                'ip_address' => '192.168.1.101',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'create',
                'model_type' => 'Assignment',
                'model_id' => 1,
                'description' => 'Affectation de Jean Dupont à la campagne Refonte Site E-commerce',
                'ip_address' => '192.168.1.100',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'update',
                'model_type' => 'Timesheet',
                'model_id' => 1,
                'description' => 'Validation de la feuille de temps de Jean Dupont',
                'ip_address' => '192.168.1.102',
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
                'model_type' => 'Assignment',
                'model_id' => 3,
                'description' => 'Suppression d\'affectation terminée',
                'ip_address' => '192.168.1.100',
            ],
            [
                'user_id' => User::first()->id,
                'action' => 'create',
                'model_type' => 'PlanningAssignment',
                'model_id' => 1,
                'description' => 'Assignation du planning standard à Jean Dupont',
                'ip_address' => '192.168.1.103',
            ],
        ];

        foreach ($activityLogs as $activityLog) {
            ActivityLog::create($activityLog);
        }
    }
}
