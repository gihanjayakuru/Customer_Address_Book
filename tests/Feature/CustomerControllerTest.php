<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_customer_creation()
    {
        $user = User::factory()->create();
        $response= $this->actingAs($user, 'api')
            ->postJson('/api/customers', [
                'name' => 'Gihan',
                'company' => 'GEJ pvt.',
                'phone' => '0772520310',
                'email' => 'gihan@example.com',
                'country' => 'SL',
                'status' => 'Active',
                'addresses' => [
                    ['number' => '123', 'street' => 'Main street', 'city' => 'Colombo']
                ]
            ]);

            $response->assertStatus(201);
    }
}
