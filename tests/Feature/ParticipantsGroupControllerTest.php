<?php

namespace Tests\Feature;

use App\Models\HolidayPlan;
use App\Models\ParticipantsGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ParticipantsGroupControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user for the tests
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function testUpdate_validData()
    {
        // Create ParticipantsGroup, HolidayPlan, and Participant
        $participantsGroup = ParticipantsGroup::factory()->create();
        $newHolidayPlan = HolidayPlan::factory()->create();
        $newParticipant = User::factory()->create();

        $data = [
            'holiday_plan_id' => $newHolidayPlan->id,
            'participant_id' => $newParticipant->id,
        ];

        $response = $this->post('/api/participants-groups/' . $participantsGroup->id, $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'ParticipantsGroup updated successfully',
                'data' => [
                    'id' => $participantsGroup->id,
                    'holiday_plan_id' => $newHolidayPlan->id,
                    'participant_id' => $newParticipant->id,
                ],
            ]);
    }

    public function testUpdate_missingHolidayPlanId()
    {
        // Create ParticipantsGroup and Participant
        $participantsGroup = ParticipantsGroup::factory()->create();
        $newParticipant = User::factory()->create();

        $data = [
            'participant_id' => $newParticipant->id,
        ];

        $response = $this->post('/api/participants-groups/' . $participantsGroup->id, $data);

        $response->assertStatus(422);
    }

    public function testIndex_noParticipantsGroups()
    {
        $response = $this->get('/api/participants-groups');

        $response->assertStatus(200)
            ->assertJson([]);
    }

    public function testShow_notFound()
    {
        $response = $this->get('/api/participants-groups/999'); // Non-existent ID

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Participant Group not found',
            ]);
    }

    public function testStore_invalidData()
    {
        // Invalid data: missing holiday_plan_id
        $data = [
            'participant_id' => 1,
        ];

        $response = $this->post('/api/participants-groups', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'holiday_plan_id',
                ],
            ]);
    }

    public function testUpdate_notFound()
    {
        // Attempt to update a non-existent ParticipantsGroup
        $data = [
            'holiday_plan_id' => 1,
            'participant_id' => 1,
        ];

        $response = $this->post('/api/participants-groups/999', $data);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Participant Group not found',
            ]);
    }

    public function testDestroy()
    {
        // Create a ParticipantsGroup to delete
        $participantsGroup = ParticipantsGroup::factory()->create();

        $response = $this->delete('/api/participants-groups/' . $participantsGroup->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'ParticipantsGroup deleted successfully',
            ]);

        // Check if the ParticipantsGroup has been deleted from the database
        $this->assertDatabaseMissing('participants_groups', [
            'id' => $participantsGroup->id,
        ]);
    }
}
