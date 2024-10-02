@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Project</h1>
        <form id="project-update-form" action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Project Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $project->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description', $project->description) }}</textarea>
            </div>

            {{-- customer Search and Select --}}
            <div class="form-group">
                <label for="customer-search">Search Customer by Name</label>
                <input type="text" id="customer-search" class="form-control" placeholder="Search customer...">
                <ul id="customer-results" class="list-group mt-2" style="max-height: 200px; overflow-y: auto;">
                    @foreach ($customers as $customer)
                        <li class="list-group-item customer-item" data-id="{{ $customer->id }}">{{ $customer->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="form-group">
                <label for="selected-customers">Selected Customers</label>
                <div id="selected-customers-list">
                    @foreach ($project->customers as $customer)
                        <div class="selected-customer" data-id="{{ $customer->id }}">
                            {{ $customer->name }} <button type="button" class="btn btn-danger btn-sm remove-customer"
                                data-id="{{ $customer->id }}">Remove</button>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="selected-customers" name="customers[]">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customerSearchInput = document.getElementById('customer-search');
            const customerResults = document.getElementById('customer-results');
            const selectedCustomersList = document.getElementById('selected-customers-list');
            const selectedCustomersInput = document.getElementById('selected-customers');

            let selectedCustomers = @json($project->customers->pluck('id'));

            customerSearchInput.addEventListener('keyup', function() {
                const searchTerm = customerSearchInput.value.toLowerCase();
                const customerItems = customerResults.querySelectorAll('.customer-item');

                customerItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            customerResults.addEventListener('click', function(e) {
                if (e.target.classList.contains('customer-item')) {
                    const customerId = e.target.getAttribute('data-id');
                    const customerName = e.target.textContent;

                    if (!selectedCustomers.includes(parseInt(customerId))) {
                        selectedCustomers.push(parseInt(customerId));
                        const newCustomerDiv = document.createElement('div');
                        newCustomerDiv.className = 'selected-customer';
                        newCustomerDiv.dataset.id = customerId;
                        newCustomerDiv.innerHTML =
                            `${customerName} <button type='button' class='btn btn-danger btn-sm remove-customer' data-id='${customerId}'>Remove</button>`;

                        selectedCustomersList.appendChild(newCustomerDiv);
                        updateSelectedCustomersInput();
                    }
                }
            });

            selectedCustomersList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-customer')) {
                    const customerId = e.target.dataset.id;
                    selectedCustomers = selectedCustomers.filter(id => id !== parseInt(customerId));
                    e.target.parentElement.remove();
                    updateSelectedCustomersInput();
                }
            });

            function updateSelectedCustomersInput() {
                selectedCustomersInput.value = selectedCustomers.join(',');
            }
        });
    </script>
@endsection
