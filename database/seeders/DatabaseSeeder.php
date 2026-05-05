<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PositionSeeder::class,
            EmployeeSeeder::class,
            CampaignSeeder::class,
            AssignmentSeeder::class,
            PlanningModelSeeder::class,
            PlanningAssignmentSeeder::class,
            TimesheetSeeder::class,
            TimesheetEntrySeeder::class,
            ActivityLogSeeder::class,
            EmployeeHistorySeeder::class,
            AssignmentHistorySeeder::class,
            PlanningHistorySeeder::class,
            TimesheetHistorySeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
