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
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 1,
                'data' => json_encode([
                    'title' => 'Nouvelle campagne créée',
                    'message' => 'La campagne "Refonte Site E-commerce" a été créée avec succès.',
                    'action_url' => '/campaigns/1',
                ]),
                'read_at' => null,
            ],
            [
                'type' => 'warning',
                'notifiable_type' => 'App\Models\Employee',
                'notifiable_id' => 2,
                'data' => json_encode([
                    'title' => 'Feuille de temps à valider',
                    'message' => 'La feuille de temps de Marie Martin est en attente de validation.',
                    'action_url' => '/timesheets/2',
                ]),
                'read_at' => '2024-04-08 10:30:00',
            ],
            [
                'type' => 'success',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 1,
                'data' => json_encode([
                    'title' => 'Planning validé',
                    'message' => 'Le planning de Jean Dupont a été validé avec succès.',
                    'action_url' => '/planning-assignments/1',
                ]),
                'read_at' => '2024-04-01 09:15:00',
            ],
            [
                'type' => 'error',
                'notifiable_type' => 'App\Models\Employee',
                'notifiable_id' => 3,
                'data' => json_encode([
                    'title' => 'Erreur de pointage',
                    'message' => 'Un problème a été détecté lors du pointage de Pierre Durand.',
                    'action_url' => '/timesheets/3',
                ]),
                'read_at' => null,
            ],
            [
                'type' => 'info',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 2,
                'data' => json_encode([
                    'title' => 'Nouvel employé',
                    'message' => 'Sophie Lefebvre a rejoint l\'équipe en tant que Superviseur.',
                    'action_url' => '/employees/4',
                ]),
                'read_at' => '2024-03-15 14:20:00',
            ],
            [
                'type' => 'warning',
                'notifiable_type' => 'App\Models\Employee',
                'notifiable_id' => 4,
                'data' => json_encode([
                    'title' => 'Affectation modifiée',
                    'message' => 'Votre affectation a été modifiée. Veuillez consulter les détails.',
                    'action_url' => '/assignments/3',
                ]),
                'read_at' => null,
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}
