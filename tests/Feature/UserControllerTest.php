<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function test_it_can_fetch_all_users_authenticated()
    {
        Passport::actingAs(User::factory()->create());

        $response = $this->get('/api/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'email', 'created_at', 'updated_at'],
        ]);
    }

    public function test_it_can_fetch_specific_user_authenticated()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->get("/api/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertJson(['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
    }

    public function test_it_can_update_user_authenticated()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->post("/api/users/{$user->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $updatedData);
    }

    public function test_it_can_delete_user_authenticated()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->delete("/api/users/{$user->id}");

        $response->assertStatus(200);
    }
}
