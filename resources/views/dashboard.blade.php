@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>

    <div class="row">
        <!-- Customers Summary -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Customers</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $customerCount }}</h5>
                    <p class="card-text">Customers in the system</p>
                    <a href="{{ route('customers.index') }}" class="btn btn-light">View Customers</a>
                </div>
            </div>
        </div>

        <!-- Projects Summary -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Projects</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $projectCount }}</h5>
                    <p class="card-text">Projects in the system</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-light">View Projects</a>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Quick Links</div>
                <div class="card-body">
                    <p class="card-text">
                        <a href="{{ route('customers.create') }}" class="btn btn-light mb-2">Add New Customer</a>
                    </p>
                    <p class="card-text">
                        <a href="{{ route('projects.create') }}" class="btn btn-light mb-2">Add New Project</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection