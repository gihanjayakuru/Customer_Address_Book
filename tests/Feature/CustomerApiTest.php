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
        Customer::factory(5)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/customers');
        $response->assertOk()->assertJsonStructure([
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
            'name' => 'New Customer',
            'company' => 'New Co',
            'phone' => '1234567890',
            'email' => 'new@example.com',
            'country' => 'USA'
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/customers', $customerData);
        $response->assertCreated()->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'company',
                'phone',
                'email'
            ]
        ]);
    }

    public function test_can_update_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $updateData = [
            'name' => 'Jane Doe Updated',
            'company' => 'JD Updated Inc.',
            'phone' => '9876543210',
            'email' => 'janedoeupdated@example.com',
            'country' => 'USA',
        ];

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/customers/{$customer->id}", $updateData);
        $response->assertOk()->assertJson([
            'data' => [
                'name' => 'Jane Doe Updated'
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
