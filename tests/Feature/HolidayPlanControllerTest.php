<?php

namespace Tests\Feature;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class HolidayPlanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Passport::actingAs(User::factory()->create());
    }

    private function createHolidayPlan()
    {
        return HolidayPlan::factory()->create();
    }

    private function getHolidayPlans()
    {
        return $this->getJson('/api/holiday-plans');
    }

    private function storeHolidayPlan($data)
    {
        return $this->postJson('/api/holiday-plans', $data);
    }

    private function showHolidayPlan($id)
    {
        return $this->getJson('/api/holiday-plans/' . $id);
    }

    private function updateHolidayPlan($id, $data)
    {
        return $this->postJson('/api/holiday-plans/' . $id, $data);
    }

    private function deleteHolidayPlan($id)
    {
        return $this->deleteJson('/api/holiday-plans/' . $id);
    }

    private function generatePdf($id)
    {
        return $this->get('/generate-pdf/' . $id);
    }

    public function testIndexMethodReturnsHolidayPlans()
    {
        // Arrange
        $this->createHolidayPlan();
        $this->createHolidayPlan();
        $this->createHolidayPlan();

        // Act
        $response = $this->getHolidayPlans();

        // Assert
        $response->assertStatus(200);
    }

    public function testStoreMethodCreatesHolidayPlan()
    {
        // Arrange
        $holidayPlanData = [
            'title' => 'Test Holiday Plan',
            'description' => 'This is a test holiday plan.',
            'date' => '2024-12-25',
            'location' => 'Test Location',
        ];

        // Act
        $response = $this->storeHolidayPlan($holidayPlanData);

        // Assert
        $response->assertStatus(201);
        $response->assertJsonFragment($holidayPlanData);
        $this->assertDatabaseHas('holiday_plans', $holidayPlanData);
    }

    public function testShowMethodReturnsSingleHolidayPlan()
    {
        // Arrange
        $holidayPlan = $this->createHolidayPlan();

        // Act
        $response = $this->showHolidayPlan($holidayPlan->id);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $holidayPlan->id]);
        $response->assertJsonStructure([
            'id',
            'title',
            'description',
            'date',
            'location',
            'user_id',
        ]);
    }

    public function testUpdateMethodUpdatesHolidayPlan()
    {
        // Arrange
        $holidayPlan = $this->createHolidayPlan();
        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'date' => '2025-01-01',
            'location' => 'Updated Location',
        ];

        // Act
        $response = $this->updateHolidayPlan($holidayPlan->id, $updatedData);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('holiday_plans', $updatedData);
    }

    public function testDestroyMethodDeletesHolidayPlan()
    {
        // Arrange
        $holidayPlan = $this->createHolidayPlan();

        // Act
        $response = $this->deleteHolidayPlan($holidayPlan->id);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('holiday_plans', ['id' => $holidayPlan->id]);
    }

    public function testDontGeneratePdfMethodGeneratesPdf()
    {
        // Arrange
        $holidayPlan = $this->createHolidayPlan();

        // Act
        $response = $this->generatePdf($holidayPlan->id);

        // Assert
        $response->assertStatus(404);
    }
}
