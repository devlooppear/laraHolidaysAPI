<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantsGroup extends Model
{
    use HasFactory;

    protected $table = 'participants_groups';

    protected $fillable = [
        'holiday_plan_id',
        'participant_id',
    ];

    // Define the relationships
    public function holidayPlan()
    {
        return $this->belongsTo(HolidayPlan::class, 'holiday_plan_id');
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id', 'id');
    }
}
