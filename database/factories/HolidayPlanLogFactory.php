<?php

namespace Database\Factories;

use App\Models\HolidayPlan;
use App\Models\HolidayPlanLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HolidayPlanLog>
 */
class HolidayPlanLogFactory extends Factory
{
    protected $model = HolidayPlanLog::class;

    public function definition()
    {
        return [
            'holiday_plan_id' => HolidayPlan::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'action' => $this->faker->randomElement(['create', 'update', 'delete']),
        ];
    }
}
