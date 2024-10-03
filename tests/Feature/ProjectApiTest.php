<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_projects()
    {
        $user = User::factory()->create();
        $project = Project::factory()->hasCustomers(3)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/projects');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'customers' => [
                            '*' => [
                                'id',
                                'name'
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_can_create_project()
    {
        $user = User::factory()->create();
        $customers = Customer::factory(2)->create();
        $projectData = [
            'name' => 'New Project',
            'description' => 'A new project description',
            'customers' => $customers->pluck('id')->toArray()
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/projects', $projectData);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description'
                ]
            ])
            ->assertJsonPath('data.name', 'New Project');

        $this->assertDatabaseHas('projects', ['name' => 'New Project']);
    }

    public function test_can_update_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->hasCustomers(2)->create();
        $updatedData = [
            'name' => 'Updated Project',
            'description' => 'Updated project description',
            'customers' => $project->customers->pluck('id')->toArray()
        ];

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/projects/{$project->id}", $updatedData);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'name' => 'Updated Project',
                    'description' => 'Updated project description'
                ]
            ]);

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'Updated Project']);
    }

    public function test_can_delete_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/projects/{$project->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
