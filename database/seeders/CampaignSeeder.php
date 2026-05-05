<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campaign;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = [
            [
                'name' => 'Refonte Site E-commerce',
                'description' => 'Refonte complète du site e-commerce avec nouvelles fonctionnalités et design moderne',
                'start_date' => '2024-01-15',
                'end_date' => '2024-06-30',
                'status' => 'active',
            ],
            [
                'name' => 'Application Mobile Banking',
                'description' => 'Développement d\'une application mobile pour les services bancaires',
                'start_date' => '2024-02-01',
                'end_date' => '2024-12-31',
                'status' => 'active',
            ],
            [
                'name' => 'Migration Cloud Infrastructure',
                'description' => 'Migration de l\'infrastructure vers le cloud avec optimisation des coûts',
                'start_date' => '2023-09-01',
                'end_date' => '2024-03-31',
                'status' => 'terminée',
            ],
            [
                'name' => 'CRM Integration',
                'description' => 'Intégration du nouveau système CRM avec les outils existants',
                'start_date' => '2024-03-15',
                'end_date' => '2024-08-15',
                'status' => 'active',
            ],
            [
                'name' => 'Security Audit 2024',
                'description' => 'Audit complet de sécurité et mise en conformité RGPD',
                'start_date' => '2024-04-01',
                'end_date' => '2024-05-31',
                'status' => 'inactive',
            ],
            [
                'name' => 'Data Analytics Platform',
                'description' => 'Mise en place d\'une plateforme d\'analyse de données et reporting',
                'start_date' => '2024-05-01',
                'end_date' => '2024-11-30',
                'status' => 'active',
            ],
        ];

        foreach ($campaigns as $campaign) {
            Campaign::create($campaign);
        }
    }
}
