<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignment_historys', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_historys');
    }
};
