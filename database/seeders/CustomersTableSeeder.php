<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Gihan',
            'company' => 'GEJ pvt.',
            'phone' => '0772520310',
            'email' => 'gihan@example.com',
            'country' => 'SL',
            'status' => 'Active',
        ]);
    }
}
