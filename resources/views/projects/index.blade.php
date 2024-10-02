@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Projects</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Add Project</a>

    @if ($projects->isEmpty())
    <p>No projects found.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Customers</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="project-list">
            @foreach ($projects as $project)
            <tr id="project-row-{{ $project->id }}">
                <td>{{ $project->name }}</td>
                <td>{{ $project->description }}</td>
                <td>
                    @foreach ($project->customers as $customer)
                    {{ $customer->name }}@if (!$loop->last),@endif
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-info">Edit</a>

                    <button class="btn btn-danger delete-project" data-id="{{ $project->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $projects->links() }}
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const projectList = document.getElementById('project-list');

        projectList.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('delete-project')) {
                const projectId = e.target.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this project?')) {
                    deleteProject(projectId);
                }
            }
        });

        // ajax delete request
        function deleteProject(projectId) {
            fetch(`/projects/${projectId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`project-row-${projectId}`).remove();
                    alert('Project deleted successfully.');
                } else {
                    alert('Failed to delete the project.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
</script>
@endsection