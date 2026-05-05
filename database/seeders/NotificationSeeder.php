<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'type' => 'info',
                'notifiable_type' => 'User',
                'notifiable_id' => 1,
                'data' => [
                    'title' => 'Nouvelle campagne créée',
                    'message' => 'La campagne "Refonte Site E-commerce" a été créée avec succès',
                    'action_url' => '/campaigns/1',
                ],
                'read_at' => null,
            ],
            [
                'type' => 'success',
                'notifiable_type' => 'User',
                'notifiable_id' => 2,
                'data' => [
                    'title' => 'Feuille de temps validée',
                    'message' => 'Votre feuille de temps du 01/04/2024 a été validée',
                    'action_url' => '/timesheets/1',
                ],
                'read_at' => now(),
            ],
            [
                'type' => 'warning',
                'notifiable_type' => 'User',
                'notifiable_id' => 3,
                'data' => [
                    'title' => 'Planning en attente de validation',
                    'message' => 'Votre planning doit être validé par un superviseur',
                    'action_url' => '/planning/assignments/1',
                ],
                'read_at' => null,
            ],
            [
                'type' => 'info',
                'notifiable_type' => 'Employee',
                'notifiable_id' => 4,
                'data' => [
                    'title' => 'Nouvelle affectation',
                    'message' => 'Vous avez été affecté au projet "Application Mobile Banking"',
                    'action_url' => '/assignments/4',
                ],
                'read_at' => now(),
            ],
            [
                'type' => 'error',
                'notifiable_type' => 'User',
                'notifiable_id' => 1,
                'data' => [
                    'title' => 'Erreur de synchronisation',
                    'message' => 'La synchronisation des données a échoué, veuillez réessayer',
                    'action_url' => null,
                ],
                'read_at' => null,
            ],
            [
                'type' => 'success',
                'notifiable_type' => 'Employee',
                'notifiable_id' => 5,
                'data' => [
                    'title' => 'Promotion validée',
                    'message' => 'Félicitations! Votre promotion a été validée',
                    'action_url' => '/employees/5',
                ],
                'read_at' => now(),
            ],
            [
                'type' => 'info',
                'notifiable_type' => 'User',
                'notifiable_id' => 2,
                'data' => [
                    'title' => 'Rapport disponible',
                    'message' => 'Le rapport mensuel est maintenant disponible',
                    'action_url' => '/reports/monthly',
                ],
                'read_at' => null,
            ],
            [
                'type' => 'warning',
                'notifiable_type' => 'Employee',
                'notifiable_id' => 6,
                'data' => [
                    'title' => 'Deadline approche',
                    'message' => 'La deadline du projet "CRM Integration" approche',
                    'action_url' => '/campaigns/4',
                ],
                'read_at' => null,
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}
