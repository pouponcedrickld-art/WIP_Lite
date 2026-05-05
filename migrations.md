// 01_create_roles_table.php
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name'); 
    $table->timestamps();
});

// 02_create_positions_table.php
Schema::create('positions', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code')->unique();
    $table->text('description')->nullable();
    $table->timestamps();
});

// 03_create_campaigns_table.php
Schema::create('campaigns', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->string('status')->default('active'); // active, inactive, terminée
    $table->timestamps();
});

Bloc B : Utilisateurs & Employés
PHP

// 04_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->foreignId('role_id')->constrained();
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamp('email_verified_at')->nullable();
    $table->timestamps();
});

// 05_create_employees_table.php
Schema::create('employees', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    $table->string('matricule')->unique();
    $table->string('first_name');
    $table->string('last_name');
    $table->date('birth_date');
    $table->string('phone');
    $table->string('email');
    $table->text('address');
    $table->foreignId('position_id')->constrained();
    $table->decimal('salary_base', 12, 2);
    $table->string('status')->default('actif'); // actif, suspendu, inactif
    $table->timestamps();
});

Bloc C : Affectations & Plannings
PHP

// 06_create_assignments_table.php
Schema::create('assignments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained();
    $table->foreignId('campaign_id')->constrained();
    $table->foreignId('manager_id')->nullable()->constrained('employees');
    $table->foreignId('position_id')->constrained();
    $table->string('status')->default('actif');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->timestamps();
});

// 07_create_planning_models_table.php
Schema::create('planning_models', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->float('monday_hours')->default(0);
    $table->float('tuesday_hours')->default(0);
    $table->float('wednesday_hours')->default(0);
    $table->float('thursday_hours')->default(0);
    $table->float('friday_hours')->default(0);
    $table->float('saturday_hours')->default(0);
    $table->float('sunday_hours')->default(0);
    $table->float('total_hours')->default(0);
    $table->foreignId('created_by')->constrained('users');
    $table->timestamps();
});

// 08_create_planning_assignments_table.php
Schema::create('planning_assignments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('planning_model_id')->constrained();
    $table->foreignId('employee_id')->constrained();
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->string('status')->default('en attente');
    $table->foreignId('validated_by')->nullable()->constrained('employees');
    $table->timestamp('validated_at')->nullable();
    $table->timestamps();
});

Bloc D : Pointage (Timesheets)
PHP

// 09_create_timesheets_table.php
Schema::create('timesheets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained();
    $table->date('period_start');
    $table->date('period_end');
    $table->string('status')->default('brouillon');
    $table->foreignId('validated_by')->nullable()->constrained('employees');
    $table->timestamp('validated_at')->nullable();
    $table->timestamps();
});

// 10_create_timesheet_entries_table.php
Schema::create('timesheet_entries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('timesheet_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->time('check_in')->nullable();
    $table->time('check_out')->nullable();
    $table->integer('break_duration')->default(0); // en minutes
    $table->float('total_hours')->default(0);
    $table->float('planned_hours')->default(0);
    $table->float('overtime_hours')->default(0);
    $table->string('absence_type')->nullable();
    $table->text('comment')->nullable();
    $table->timestamps();
});

Bloc E : Logs, Notifs & Historiques
PHP

// 11_create_activity_logs_table.php
Schema::create('activity_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained();
    $table->string('action');
    $table->string('model_type');
    $table->unsignedBigInteger('model_id');
    $table->text('description');
    $table->string('ip_address')->nullable();
    $table->timestamps();
});

// 12_create_notifications_table.php
Schema::create('notifications', function (Blueprint $table) { // Note: Laravel a son propre format, mais voici le vôtre
    $table->id();
    $table->string('type');
    $table->string('notifiable_type');
    $table->unsignedBigInteger('notifiable_id');
    $table->json('data');
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});

// 13_create_employee_histories_table.php
Schema::create('employee_histories', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained();
    $table->foreignId('old_position_id')->nullable()->constrained('positions');
    $table->foreignId('new_position_id')->nullable()->constrained('positions');
    $table->string('old_status')->nullable();
    $table->string('new_status')->nullable();
    $table->foreignId('changed_by')->constrained('users');
    $table->text('reason')->nullable();
    $table->timestamps();
});

// 14_create_assignment_histories_table.php
Schema::create('assignment_histories', function (Blueprint $table) {
    $table->id();
    $table->foreignId('assignment_id')->constrained();
    $table->foreignId('employee_id')->constrained();
    $table->foreignId('old_manager_id')->nullable()->constrained('employees');
    $table->foreignId('new_manager_id')->nullable()->constrained('employees');
    $table->foreignId('old_campaign_id')->nullable()->constrained('campaigns');
    $table->foreignId('new_campaign_id')->nullable()->constrained('campaigns');
    $table->string('action_type'); // assign, release, transfer
    $table->foreignId('changed_by')->constrained('users');
    $table->text('reason')->nullable();
    $table->timestamps();
});

// 15_create_planning_histories_table.php
Schema::create('planning_histories', function (Blueprint $table) {
    $table->id();
    $table->foreignId('planning_assignment_id')->constrained();
    $table->string('old_status')->nullable();
    $table->string('new_status')->nullable();
    $table->foreignId('changed_by')->constrained('users');
    $table->text('reason')->nullable();
    $table->timestamps();
});

// 16_create_timesheet_histories_table.php
Schema::create('timesheet_histories', function (Blueprint $table) {
    $table->id();
    $table->foreignId('timesheet_id')->constrained();
    $table->foreignId('employee_id')->constrained();
    $table->string('old_status')->nullable();
    $table->string('new_status')->nullable();
    $table->foreignId('changed_by')->constrained('users');
    $table->text('reason')->nullable();
    $table->timestamps();
});