<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
       
        $project1 = Project::create([
            'name' => 'Project Alpha',
            'description' => 'This is a description for Project Alpha.'
        ]);

        $project2 = Project::create([
            'name' => 'Project Beta',
            'description' => 'This is a description for Project Beta.'
        ]);

        
        $customerIds = Customer::pluck('id')->all();

        // assign customers to projects,
        if (!empty($customerIds)) {
            $project1->customers()->attach($customerIds);  
            $project2->customers()->attach(array_slice($customerIds, 0, 1));  
        }
    }
}
