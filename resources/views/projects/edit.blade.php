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
            const form = document.getElementById('project-update-form');
            const statusMessage = document.createElement('div');
            form.appendChild(statusMessage);

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

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);

                selectedCustomers.forEach(id => {
                    formData.append('customers[]', id.toString());
                });

                const url = form.getAttribute('action');

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            statusMessage.className = 'alert alert-success';
                            statusMessage.textContent = data.message;
                            setTimeout(() => window.location.href = '/projects', 1000);
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        statusMessage.className = 'alert alert-danger';
                        statusMessage.textContent = 'Error: ' + error.message;
                    });
            });
        });
    </script>
@endsection
