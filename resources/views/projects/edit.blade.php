@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Project</h1>
    <form id="project-update-form" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Project Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}"
                required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description"
                required>{{ old('description', $project->description) }}</textarea>
        </div>

        {{-- customer Search and Select  --}}
        <div class="form-group">
            <label for="customer-search">Search Customer by Name</label>
            <input type="text" id="customer-search" class="form-control" placeholder="Search customer...">
            <ul id="customer-results" class="list-group mt-2" style="max-height: 200px; overflow-y: auto;">
                @foreach($customers as $customer)
                <li class="list-group-item customer-item" data-id="{{ $customer->id }}">{{ $customer->name }}</li>
                @endforeach
            </ul>
        </div>

     {{-- selected customers  --}}
        <div class="form-group">
            <label for="selected-customers">Selected Customers</label>
            <div id="selected-customers-list">
                @foreach($project->customers as $customer)
                <div class="selected-customer" id="selected-customer-{{ $customer->id }}">
                    {{ $customer->name }} <button type="button" class="btn btn-danger btn-sm remove-customer"
                        data-id="{{ $customer->id }}">Remove</button>
                </div>
                @endforeach
            </div>
            <input type="hidden" id="selected-customers" name="customers" value="{{ $selectedCustomers }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <div id="status-message" class="alert" style="display:none;"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerSearchInput = document.getElementById('customer-search');
        const customerResults = document.getElementById('customer-results');
        const selectedCustomersList = document.getElementById('selected-customers-list');
        const selectedCustomersInput = document.getElementById('selected-customers');
        const form = document.getElementById('project-update-form');
        const statusMessage = document.getElementById('status-message');

        let selectedCustomers = {{ json_encode($project->customers->pluck('id')) }};  // Initialize with existing customers

        // Filter customers as the user types in the search box
        customerSearchInput.addEventListener('keyup', function() {
            const searchTerm = customerSearchInput.value.toLowerCase();
            const customerItems = customerResults.getElementsByClassName('customer-item');

            Array.from(customerItems).forEach(function(item) {
                const customerName = item.textContent.toLowerCase();
                if (customerName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Add customer to the selected list when clicked
        customerResults.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('customer-item')) {
                const selectedValue = e.target.getAttribute('data-id');
                const selectedText = e.target.textContent;

                if (!selectedCustomers.includes(selectedValue)) {
                    selectedCustomers.push(selectedValue);
                    updateSelectedCustomersList(selectedText, selectedValue);
                }
            }
        });

        function updateSelectedCustomersList(text, value) {
            const customerItem = document.createElement('div');
            customerItem.classList.add('selected-customer');
            customerItem.innerHTML = `${text} <button type="button" class="btn btn-danger btn-sm remove-customer" data-id="${value}">Remove</button>`;
            selectedCustomersList.appendChild(customerItem);

            updateSelectedCustomersInput();
        }

        selectedCustomersList.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-customer')) {
                const customerId = e.target.getAttribute('data-id');
                selectedCustomers = selectedCustomers.filter(customer => customer != customerId);
                e.target.parentElement.remove();

                updateSelectedCustomersInput();
            }
        });

        function updateSelectedCustomersInput() {
            selectedCustomersInput.value = selectedCustomers.join(',');
        }

        // handle ajax form submission for update
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch('{{ route('projects.update', $project->id) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusMessage.classList.add('alert-success');
                    statusMessage.textContent = data.message;
                    statusMessage.style.display = 'block';
                    setTimeout(() => window.location.href = '/projects', 1000);
                } else {
                    statusMessage.classList.add('alert-danger');
                    statusMessage.textContent = 'Error: ' + data.message;
                    statusMessage.style.display = 'block';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection