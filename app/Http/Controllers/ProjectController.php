<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('customers')->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('projects.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $project = Project::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);

            $customerIds = explode(',', $request->input('customers'));
            $project->customers()->sync($customerIds);

            return response()->json(['success' => true, 'message' => 'Project created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to create project.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('customers');
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $customers = Customer::all(); 
        $selectedCustomers = $project->customers->pluck('id')->implode(',');

        return view('projects.edit', compact('project', 'customers', 'selectedCustomers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        try {
            $validatedData = $request->validated();

            $project->update($validatedData);
            $customerIds = explode(',', $request->input('customers'));
            $project->customers()->sync($customerIds);

            return response()->json(['success' => true, 'message' => 'Project updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update project.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}