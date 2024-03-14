<?php

namespace Database\Factories;

use App\Models\ParticipantsGroup;
use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Redis;

class ParticipantsGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ParticipantsGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $holidayPlanIds = HolidayPlan::pluck('id')->toArray();
        $participantIds = User::pluck('id')->toArray();

        return [
            'holiday_plan_id' => $this->faker->randomElement($holidayPlanIds),
            'participant_id' => $this->faker->randomElement($participantIds),
        ];
    }
}
