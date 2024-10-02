@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add/Edit Project</h1>
        <form id="project-form" method="POST" action="{{ route('projects.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Project Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>

            {{-- Customer Search and Select --}}
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
                <div id="selected-customers-list"></div>
                <input type="hidden" id="selected-customers" name="customers[]">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <div id="status-message" class="alert" style="display:none;"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customerSearchInput = document.getElementById('customer-search');
            const customerResults = document.getElementById('customer-results');
            const selectedCustomersList = document.getElementById('selected-customers-list');
            const selectedCustomersInput = document.getElementById('selected-customers');
            const form = document.getElementById('project-form');
            const statusMessage = document.getElementById('status-message');

            let selectedCustomers = [];

            customerSearchInput.addEventListener('keyup', function() {
                const searchTerm = customerSearchInput.value.toLowerCase();
                const customerItems = Array.from(customerResults.getElementsByClassName('customer-item'));
                customerItems.forEach(item => {
                    item.style.display = item.textContent.toLowerCase().includes(searchTerm) ?
                        'block' : 'none';
                });
            });

            customerResults.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('customer-item')) {
                    const customerId = e.target.getAttribute('data-id');
                    const customerName = e.target.textContent;
                    if (!selectedCustomers.includes(customerId)) {
                        selectedCustomers.push(customerId);
                        const customerTag = document.createElement('div');
                        customerTag.className = 'selected-customer-tag';
                        customerTag.textContent = customerName + ' ';
                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.textContent = 'Remove';
                        removeButton.className = 'btn btn-sm btn-danger';
                        removeButton.onclick = function() {
                            selectedCustomers = selectedCustomers.filter(id => id !== customerId);
                            customerTag.remove();
                            updateSelectedCustomersInput();
                        };
                        customerTag.appendChild(removeButton);
                        selectedCustomersList.appendChild(customerTag);
                        updateSelectedCustomersInput();
                    }
                }
            });

            function updateSelectedCustomersInput() {
                const selectedIds = selectedCustomers.map(id => parseInt(id));
                selectedCustomersInput.value = JSON.stringify(selectedIds);
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const data = {
                    name: document.getElementById('name').value,
                    description: document.getElementById('description').value,
                    customers: selectedCustomers
                };

                fetch('{{ route('projects.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
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
