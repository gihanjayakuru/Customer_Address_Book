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
        $projects = Project::with('customers')->paginate(10);
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

            $project->customers()->sync($validatedData['customers'] ?? []);

            return response()->json(['success' => true, 'message' => 'Project successfully created!']);
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
        $selectedCustomers = $project->customers->pluck('id');
        return view('projects.edit', compact('project', 'customers', 'selectedCustomers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $project->update($validated);

        if (isset($validated['customers']) && is_array($validated['customers'])) {

            $customerIds = array_map('intval', $validated['customers']);
            $project->customers()->sync($customerIds);
        } else {
            $project->customers()->detach();
        }
        return response()->json(['success' => true, 'message' => 'Project successfully updated!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return response()->json(['success' => true, 'message' => 'Project deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete project.']);
        }
    }
}
