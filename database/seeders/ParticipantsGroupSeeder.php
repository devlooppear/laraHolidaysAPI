<?php

namespace Database\Seeders;

use App\Models\ParticipantsGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParticipantsGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ParticipantsGroup::factory(50)->create();
    }
}
