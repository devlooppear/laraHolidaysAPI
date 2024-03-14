<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPlanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'holiday_plan_id',
        'user_id',
        'action'
    ];

    /**
     * Get the holiday plan associated with the log.
     */
    public function holidayPlan()
    {
        return $this->belongsTo(HolidayPlan::class);
    }

    /**
     * Get the user associated with the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
