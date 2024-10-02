<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectApiController extends Controller
{
    public function index()
    {
        return ProjectResource::collection(Project::with('customers')->get());
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());
        $project->customers()->sync($request->customers);
        return new ProjectResource($project);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project->load('customers'));
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        $project->customers()->sync($request->customers);
        return new ProjectResource($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
    }
}
