<?php

namespace Tests\Feature;

use App\Models\HolidayPlanLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class HolidayPlanLogControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate using Passport for every test
        $this->user = Passport::actingAs(User::factory()->create());
    }

    private function createHolidayPlanLog()
    {
        return HolidayPlanLog::factory()->create();
    }

    private function getHolidayPlanLogs()
    {
        return $this->getJson('/api/holiday-plan-logs');
    }

    private function showHolidayPlanLog($id)
    {
        return $this->getJson('/api/holiday-plan-logs/' . $id);
    }

    private function deleteHolidayPlanLog($id)
    {
        return $this->deleteJson('/api/holiday-plan-logs/' . $id);
    }

    public function testIndexMethodReturnsHolidayPlanLogs()
    {
        // Arrange
        $this->createHolidayPlanLog();
        $this->createHolidayPlanLog();
        $this->createHolidayPlanLog();

        // Act
        $response = $this->getHolidayPlanLogs();

        // Assert
        $response->assertStatus(200);
    }


    public function testShowMethodReturnsSingleHolidayPlanLog()
    {
        // Arrange
        $holidayPlanLog = $this->createHolidayPlanLog();

        // Act
        $response = $this->showHolidayPlanLog($holidayPlanLog->id);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $holidayPlanLog->id]);
        $response->assertJsonStructure([
            'id',
            'holiday_plan_id',
            'user_id',
            'action',
        ]);
    }

    public function testDestroyMethodDeletesHolidayPlanLog()
    {
        // Arrange
        $holidayPlanLog = $this->createHolidayPlanLog();

        // Act
        $response = $this->deleteHolidayPlanLog($holidayPlanLog->id);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('holiday_plan_logs', ['id' => $holidayPlanLog->id]);
    }
}
