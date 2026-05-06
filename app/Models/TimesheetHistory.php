<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class TimesheetHistory extends Model
{
    protected $table = 'timesheet_historys';
    
    public $timestamps = false;
    protected $fillable = ['timesheet_id', 'employee_id', 'old_status', 'new_status', 'changed_by', 'reason', 'created_at'];

    public function timesheet() {
        return $this->belongsTo(Timesheet::class);
    }
    
    public function author() {
        return $this->belongsTo(Employee::class, 'changed_by');
    }
}
