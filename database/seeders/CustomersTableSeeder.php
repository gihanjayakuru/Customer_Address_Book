<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    public function run()
    {
        //create customers
        $customers = [
            [
                'name' => 'John Doe',
                'company' => 'ABC Corp',
                'phone' => '1234567890',
                'email' => 'john@example.com',
                'country' => 'USA',
                'status' => 'Active'
            ],
            [
                'name' => 'Jane Smith',
                'company' => 'XYZ Inc',
                'phone' => '0987654321',
                'email' => 'jane@example.com',
                'country' => 'Canada',
                'status' => 'Inactive'
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        //create addresses for customers
        Address::factory()->count(2)->create([
            'customer_id' => DB::table('customers')->where('name', 'John Doe')->first()->id,
            'number' => '123',
            'street' => 'Main St',
            'city' => 'Anytown'
        ]);

        Address::factory()->count(1)->create([
            'customer_id' => DB::table('customers')->where('name', 'Jane Smith')->first()->id,
            'number' => '456',
            'street' => 'Elm St',
            'city' => 'Ottawa'
        ]);
    }
}
