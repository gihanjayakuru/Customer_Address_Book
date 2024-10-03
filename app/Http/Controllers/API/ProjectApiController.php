<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectApiController extends Controller
{
    public function index()
    {
        $projects = Project::with('customers')->get();
        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());
        $project->customers()->sync($request->input('customers', []));
        return new ProjectResource($project);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project->load('customers'));
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        $project->customers()->sync($request->input('customers', []));
        return new ProjectResource($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}
