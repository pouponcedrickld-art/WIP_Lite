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
        $employees = [
            [
                'user_id' => 1,
                'matricule' => 'EMP0001',
                'first_name' => 'Jean',
                'last_name' => 'Dupont',
                'birth_date' => '1985-03-15',
                'phone' => '0612345678',
                'email' => 'jean.dupont@example.com',
                'address' => '123 Rue de la République, 75001 Paris',
                'position_id' => Position::where('code', 'MGR')->first()->id,
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
                'position_id' => Position::where('code', 'DEV_SR')->first()->id,
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
            [
                'matricule' => 'EMP0005',
                'first_name' => 'Thomas',
                'last_name' => 'Bernard',
                'birth_date' => '1995-09-12',
                'phone' => '0656789012',
                'email' => 'thomas.bernard@example.com',
                'address' => '654 Place de la Bastille, 75011 Paris',
                'position_id' => Position::where('code', 'DEV_JR')->first()->id,
                'salary_base' => 35000.00,
                'status' => 'actif',
            ],
            [
                'matricule' => 'EMP0006',
                'first_name' => 'Camille',
                'last_name' => 'Petit',
                'birth_date' => '1993-02-18',
                'phone' => '0667890123',
                'email' => 'camille.petit@example.com',
                'address' => '987 Avenue Foch, 75116 Paris',
                'position_id' => Position::where('code', 'ANA')->first()->id,
                'salary_base' => 45000.00,
                'status' => 'actif',
            ],
            [
                'matricule' => 'EMP0007',
                'first_name' => 'Nicolas',
                'last_name' => 'Robert',
                'birth_date' => '1991-06-25',
                'phone' => '0678901234',
                'email' => 'nicolas.robert@example.com',
                'address' => '147 Rue de Rivoli, 75004 Paris',
                'position_id' => Position::where('code', 'TECH')->first()->id,
                'salary_base' => 40000.00,
                'status' => 'actif',
            ],
            [
                'matricule' => 'EMP0008',
                'first_name' => 'Isabelle',
                'last_name' => 'Dubois',
                'birth_date' => '1989-12-03',
                'phone' => '0689012345',
                'email' => 'isabelle.dubois@example.com',
                'address' => '258 Boulevard Haussmann, 75009 Paris',
                'position_id' => Position::where('code', 'DES')->first()->id,
                'salary_base' => 48000.00,
                'status' => 'actif',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
