<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    public function run()
    {
        $customers = Customer::all();

        Project::factory()
            ->count(5)
            ->create()
            ->each(function ($project) use ($customers) {
                $project->customers()->attach(
                    $customers->random(2)->pluck('id')->toArray()
                );
            });
    }
}
