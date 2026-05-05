<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\TimesheetEntry;
use App\Models\TimesheetHistory;

class Timesheet extends Model
{
    protected $fillable = ['employee_id', 'period_start', 'period_end', 'status', 'validated_by', 'validated_at'];

    public function entries() {
        return $this->hasMany(TimesheetEntry::class);
    }

    
    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    
    public function validator() {
        return $this->belongsTo(Employee::class, 'validated_by');
    }

    public function histories() {
        return $this->hasMany(TimesheetHistory::class);
    }
}