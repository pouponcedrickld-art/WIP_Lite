<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Timesheet;

class TimesheetEntry extends Model
{
    protected $fillable = [
        'timesheet_id', 'date', 'check_in', 'check_out', 
        'break_duration', 'total_hours', 'planned_hours', 
        'overtime_hours', 'absence_type', 'comment'
    ];

    public function timesheet() {
        return $this->belongsTo(Timesheet::class);
    }
}
