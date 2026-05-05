<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Développeur Senior', 'code' => 'DEV_SR', 'description' => 'Développeur expérimenté avec plus de 5 ans d\'expérience'],
            ['name' => 'Développeur Junior', 'code' => 'DEV_JR', 'description' => 'Développeur débutant avec moins de 2 ans d\'expérience'],
            ['name' => 'Chef de Projet', 'code' => 'CP', 'description' => 'Responsable de la gestion de projet et de l\'équipe'],
            ['name' => 'Superviseur', 'code' => 'SUP', 'description' => 'Supervise les équipes techniques'],
            ['name' => 'Technicien', 'code' => 'TECH', 'description' => 'Support technique et maintenance'],
            ['name' => 'Manager', 'code' => 'MGR', 'description' => 'Manager d\'équipe ou de département'],
            ['name' => 'Analyste', 'code' => 'ANA', 'description' => 'Analyste fonctionnel ou business'],
            ['name' => 'Designer', 'code' => 'DES', 'description' => 'Designer UI/UX'],
            ['name' => 'Testeur QA', 'code' => 'QA', 'description' => 'Responsable des tests qualité'],
            ['name' => 'DevOps', 'code' => 'DEVOPS', 'description' => 'Ingénieur DevOps et infrastructure'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
