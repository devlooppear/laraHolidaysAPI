<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'user_id'
    ];

    protected $table = 'holiday_plans';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(HolidayPlanLog::class);
    }

    // Define the relationship with eager loading
    public function participantsGroups()
    {
        return $this->hasMany(ParticipantsGroup::class);
    }
}
