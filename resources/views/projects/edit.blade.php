@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Project</h2>
    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Project Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}"
                required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4"
                required>{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="customers">Customers:</label>
            <select multiple class="form-control" id="customers" name="customers[]" required>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}" {{ in_array($customer->id, old('customers', $selectedCustomers)) ?
                    'selected' : '' }}>
                    {{ $customer->name }} ({{ $customer->company }})
                </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold down Ctrl (Windows) or Command (Mac) to select multiple
                options.</small>
        </div>
        <button type="submit" class="btn btn-success">Update Project</button>
    </form>
</div>
@endsection