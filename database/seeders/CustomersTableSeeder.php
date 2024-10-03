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
        Customer::factory()
            ->count(10)
            ->has(Address::factory()->count(2))
            ->create();
    }
}
