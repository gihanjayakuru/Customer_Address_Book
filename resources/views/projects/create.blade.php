@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add/Edit Project</h1>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Project Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        {{-- customer Search and Select --}}
        <div class="form-group">
            <label for="customer-search">Search Customer by Name</label>
            <input type="text" id="customer-search" class="form-control" placeholder="Search customer...">
            <ul id="customer-results" class="list-group mt-2" style="max-height: 200px; overflow-y: auto;">
                @foreach($customers as $customer)
                <li class="list-group-item customer-item" data-id="{{ $customer->id }}">{{ $customer->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="form-group">
            <label for="selected-customers">Selected Customers</label>
            <div id="selected-customers-list"></div>
            <input type="hidden" id="selected-customers" name="customers">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerSearchInput = document.getElementById('customer-search');
        const customerResults = document.getElementById('customer-results');
        const selectedCustomersList = document.getElementById('selected-customers-list');
        const selectedCustomersInput = document.getElementById('selected-customers');

        let selectedCustomers = [];

        //filter customers as the user types in the search box
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

        //add customer to the selected list when clicked
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
                selectedCustomers = selectedCustomers.filter(customer => customer !== customerId);
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