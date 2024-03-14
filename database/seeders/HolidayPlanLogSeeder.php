<?php

// database/seeders/HolidayPlanLogSeeder.php

namespace Database\Seeders;

use App\Models\HolidayPlanLog;
use Illuminate\Database\Seeder;

class HolidayPlanLogSeeder extends Seeder
{
    public function run()
    {
        HolidayPlanLog::factory(30)->create();
    }
}