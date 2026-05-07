<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Employés spécifiques avec comptes utilisateurs
        $specificEmployees = [
            [
                'user_id' => 1,
                'matricule' => 'EMP0001',
                'first_name' => 'Jean',
                'last_name' => 'Dupont',
                'birth_date' => '1985-03-15',
                'phone' => '0612345678',
                'email' => 'jean.dupont@example.com',
                'address' => '123 Rue de la République, 75001 Paris',
                'position_id' => Position::where('code', 'RH')->first()->id,
                'salary_base' => 75000.00,
                'status' => 'actif',
            ],
            [
                'user_id' => 2,
                'matricule' => 'EMP0002',
                'first_name' => 'Marie',
                'last_name' => 'Martin',
                'birth_date' => '1990-07-22',
                'phone' => '0623456789',
                'email' => 'marie.martin@example.com',
                'address' => '456 Avenue des Champs-Élysées, 75008 Paris',
                'position_id' => Position::where('code', 'CP')->first()->id,
                'salary_base' => 65000.00,
                'status' => 'actif',
            ],
            [
                'user_id' => 3,
                'matricule' => 'EMP0003',
                'first_name' => 'Pierre',
                'last_name' => 'Durand',
                'birth_date' => '1988-11-08',
                'phone' => '0634567890',
                'email' => 'pierre.durand@example.com',
                'address' => '789 Boulevard Saint-Germain, 75006 Paris',
                'position_id' => Position::where('code', 'CP')->first()->id,
                'salary_base' => 55000.00,
                'status' => 'actif',
            ],
            [
                'user_id' => 4,
                'matricule' => 'EMP0004',
                'first_name' => 'Sophie',
                'last_name' => 'Lefebvre',
                'birth_date' => '1992-04-30',
                'phone' => '0645678901',
                'email' => 'sophie.lefebvre@example.com',
                'address' => '321 Rue Montorgueil, 75002 Paris',
                'position_id' => Position::where('code', 'SUP')->first()->id,
                'salary_base' => 60000.00,
                'status' => 'actif',
            ],
        ];

        foreach ($specificEmployees as $employee) {
            Employee::create($employee);
        }

        // Générer des employés supplémentaires avec la factory
        Employee::factory(20)->create();
    }
}
