<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Database\Seeders\CustomersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_customers()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/customers');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'company',
                        'phone',
                        'email',
                        'country',
                        'addresses'
                    ]
                ]
            ]);
    }

    public function test_can_create_customer()
    {
        $user = User::factory()->create();
        $customerData = [
            'name' => 'John Doe',
            'company' => 'JD Inc.',
            'phone' => '123456789',
            'email' => 'john.doe@example.com',
            'country' => 'USA',
            'addresses' => [
                ['number' => '123', 'street' => 'Main St', 'city' => 'Anytown']
            ]
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/customers', $customerData);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'company',
                    'phone',
                    'email',
                    'country',
                    'addresses'
                ]
            ]);
    }

    public function test_can_update_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $updatedData = [
            'name' => 'Jane Doe',
            'company' => 'JD Inc.',
            'phone' => '987654321',
            'email' => 'jane.doe@example.com',
            'country' => 'USA',
            'addresses' => [
                ['number' => '456', 'street' => 'Main St', 'city' => 'Anytown']
            ]
        ];

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/customers/{$customer->id}", $updatedData);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'name' => 'Jane Doe'
                ]
            ]);
    }

    public function test_can_delete_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/customers/{$customer->id}");

        $response->assertNoContent();
    }
}
