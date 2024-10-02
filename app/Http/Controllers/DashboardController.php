<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{ 
    public function index()
    {
        $customerCount = Customer::count(); 
        $projectCount = Project::count();

        return view('dashboard', compact('customerCount', 'projectCount'));
    }
}
